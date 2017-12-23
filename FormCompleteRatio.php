<?php
namespace aneeshikmat\yii2\FormCompleteRatio;

use yii\base\Widget;
use yii\db\Exception;

class FormCompleteRatio extends Widget
{
    /**
     * @var array the Template Option
     * This array can accept title, url, urlText, startHintText, templateBlockId, templateClassWrapper, srReaderHint
     */
    public $defTemplateOption = [
        'templateClassWrapper' => 'col-lg-6 col-md-6 col-sm-6 col-xs-12',// Block Class
        'templateBlockId'      => 'form-complete-ratio', // Block Id & prefix nested class
        'startHintText'        => 'Complete now',// Hint At the begin block
        'urlText'              => 'Complete now',// Url Text
        'url'                  => 'javascript:void(0);',// Url
        'title'                => 'Form Complete',// Main Block Title
        'srReaderHint'         => 'changes',// This value will concat with Ratio Value
        ];

    public $templateOption = [];
    /**
     * @var String to set ratio block direction
     */
    public $styleDirection = 'ltr';

    /**
     * @var Model Object to save main form model(pass full model)
     */
    public $mainModel;

    /**
     * @var Bool Ignore Assign Main Model Attribute, and use widjet only
     * This variable useful if you have general Retio Field in MainModel
     **and need to set a spesfic case for widjet in view
     *
     * false is default value
     */
    public $ignoreMainModelRatioField = false;

    /**
     * @var Array set ratio field
     *  formRatioField varialbe may be has more than options:
     *  1) formRatioField = ['field-1', 'field-2',...etc], this way used
     **    if field in current model
     *  2) formRatioField = ['field-1', ['model' => '/dir/ModelClassName']] and
     **    this way used for relational field
     *  3) formRatioField = ['field-1', ['field-3', 'field-4']] this way used
     **    if I need to add only 1 if one of field 3 or 4 is filled,
     **    in another word, if any one of inner array not empty ..thats mean its filled
     *  4) formRatioField = ['field-1', ['model' => '/dir/ModelClassName', 'conditions' => ['field_db_name' => val]]]
     **    And this way used if we need to send condtion to our defult condtion like status
     *  5) formRatioField = ['field-1', ['model' => '/dir/ModelClassName', 'oneOrMore' => 'one']
     **    and this way has a condtion calculate to check if all relational row will add or just if any one not empty will be add +1,
     *     in another word, if any one of inner array not empty ..thats mean its filled
     *
     *  {{id}} is a replacmnt to Primary key for current object
     */
    public $formRatioField;

    /**
     * @var Bool to set ratio block direction, This var accpet false and true, and zero init
     */
    public $withPercentage = 0;

    /**
     * @var Integer to determind template Style
     * 0: Clear Number, Without Any Style, And its a defualt value
     * 1: Template - 1
     * 2: Template - 2
     */
    public $templateStyle = 0;

    /**
     * Initializes the view.
     */
    public function init(){
        parent::init();

        // If main model not set
        if(!isset($this->mainModel))
            throw new Exception('You most pass main model!');

        // If new record return 0, we dont need to calclate any thing
        if($this->mainModel->isNewRecord) {
            echo 0;
            return;
        }

        // Assign Ratio Item directly from models without set it in wedjt, if its empty we will get it from wedjit
        if(!($this->ignoreMainModelRatioField)
            && isset($this->mainModel->formRatioField)
            && is_array($this->mainModel->formRatioField)){
            $this->formRatioField = $this->mainModel->formRatioField;
        }else if(empty($this->formRatioField) || !is_array($this->formRatioField)){// If empty ratio Item or is not an array
            throw new Exception('formRatioField Requird, And Most Be An Array!');
        }

        // If User Select Template one, we need to set Percentage to work normaly
        if($this->templateStyle == 1 && $this->withPercentage === 0) {
            $this->withPercentage = true;
        }

        $this->templateOption = array_merge($this->defTemplateOption, $this->templateOption);
    }

    /**
     * Runs the widget.
     */
    public function run()
    {
        if (empty($this->templateStyle) && $this->mainModel->isNewRecord){
            return;
        }elseif (empty($this->templateStyle)){
            echo $this->getCompleteProfileRatio();
        }elseif ($this->templateStyle == 1){
            echo $this->render('_template/_template_1', [
                'ratioValue'        => $this->getCompleteProfileRatio(),
                'templateOption'    => $this->templateOption
            ]);
        }elseif ($this->templateStyle == 2){
            echo $this->render('_template/_template_2', [
                'ratioValue'        => $this->getCompleteProfileRatio(),
                'templateOption'    => $this->templateOption
            ]);
        }

        $this->registerClientScript();
    }

    public function registerClientScript()
    {
        $view = $this->getView();
        FormCompleteRatioAsset::register($view);

        $js = <<<JS

JS;


        $view->registerJs($js);

    }

    /*
     * Function to Get Ratio For Form and return % for how much is done
     * This function git items form needed from formRatioField variable
     */
    private function getCompleteProfileRatio()
    {
        $mainModel = $this->mainModel;
        $items = $this->formRatioField;
        // Total if accpet fields that will used to calcuate ratio, the law is itemsFilled / itemsCount = num%
        $itemsCount = count($items);
        // Var to save how many field is fill, thats will used to calcuate ratio
        $itemsFilledCount = 0;

        // PK id for current obj
        $id = $mainModel->id;

        // Current Object
        $model = $mainModel::findOne(['id'=>$id]);
        foreach ($items as $value){
            if(is_array($value)){// Thats mean theres conditons, or hteres relational fields

                // IF this model (Relational Needed To get needed filed)
                if(isset($value['model'])){
                    if(!class_exists($value['model'])){
                        $itemsCount -= 1; // Decrasae one total items since we got error
                        continue;
                    }

                    // Addional condtion pass with array
                    $conditions = array();
                    if(isset($value['conditions'])){
                        $conditions = $value['conditions'];
                    }

                    // get count of rows, if 0 thats mean no field filled
                    $assignModel = $value['model']::find();
                    foreach ($conditions as $key => $cond){
                        if(!is_array($cond)) {
                            $cond = str_replace('{{id}}', $id, $cond);
                            $assignModel->andWhere([$key => $cond]);
                        }else{
                            array_map(function ($v) use ($id) {
                                return $v == '{{id}}' ? $id : $v;
                            }, $cond);
                            $assignModel->andWhere($cond);
                        }
                    }

                    /*
                     * First Condition Work When need to validate relation with one row,
                     **Such as if we have an user register and has many of Facebook account,
                     **and each fb account save in seperate row, in this case we will git one of these row
                     **and calclate ratio dependance if item, and this row id can determind easy by conditional option
                     *
                     * Second Condtion Work like First Condtion, but the defferance is we got all rows here
                     *
                     * Third Condtion work if we need to calclate ratio if we has any row realtion,
                     **thats mean we has check the relational has been addes
                     */
                    if(isset($value['oneOrMore']) && $value['oneOrMore'] == 'one'
                        && isset($value['modelItem']) && is_array($value['modelItem'])
                    ){
                        $assCount = 0;
                        $assModel = $assignModel->one();
                        foreach ($value['modelItem'] as $modItem) {
                            if(is_array($modItem)){
                                foreach ($modItem as $modInnerItem){
                                    if (!empty($assModel->$modInnerItem)) {
                                        $assCount += 1;
                                        break;
                                    }
                                }
                            }else{
                                if (!empty($assModel->$modItem)) {
                                    $assCount += 1;
                                }
                            }
                        }

                        if(!empty($assModel)){
                            $itemsCount += count($value['modelItem']) - 1;
                            $itemsFilledCount += $assCount;
                        }else{
                            $itemsCount--;
                        }
                    }else if(isset($value['oneOrMore']) && $value['oneOrMore'] == 'more'
                        && isset($value['modelItem']) && is_array($value['modelItem'])
                    ){
                        $assCount = 0;
                        $assModel = $assignModel->all();
                        foreach ($assModel as $asModel){
                            foreach ($value['modelItem'] as $modItem) {
                                if(is_array($modItem)){
                                    foreach ($modItem as $modInnerItem){
                                        if (!empty($asModel->$modInnerItem)) {
                                            $assCount += 1;
                                            break;
                                        }
                                    }
                                }else{
                                    if (!empty($asModel->$modItem)) {
                                        $assCount += 1;
                                    }
                                }
                            }
                        }

                        if(!empty($assModel)){
                            $itemsCount += (count($assModel) * count($value['modelItem'])) - 1;
                            $itemsFilledCount += $assCount;
                        }else{
                            $itemsCount--;
                        }
                    }else{
                        $assignModelCount = $assignModel->count();
                        // If we found record we will be increase fielld item
                        if($assignModelCount > 0) {
                            $itemsFilledCount += 1;
                        }
                    }
                }else {// is normal field - Current Model -

                    // Looping in array fields, if we found any one value will be increase filled and exit
                    foreach ($value as $val){
                        if(!empty($model->$val)){
                            $itemsFilledCount += 1;
                            break;
                        }
                    }
                }

            }else {// Direct Filled - Fields exsists in current model -
                if(!empty($model->$value)){
                    $itemsFilledCount += 1;
                }
            }
        }
        // To calclate ratio we divde items filled / itemsCount, and we * 100 to be in 100%
        $ratio = round($itemsFilledCount / $itemsCount * 100);

        // If we need a value with Percentage %
        if($this->withPercentage)
            $ratio .= '%';

        return $ratio;
    }

}
