# formCompleteRatio

formCompleteRatio Widget for yii2, to calclate ratio for any form filled by user (Profile Complete Ratio As Example)

## Screenshot from real project

![Yii2 formCompleteRatio screenshot_t1](http://2nees.com/github/formCompleteRatio/1.png)

## Screenshot for widjet when you setup this code for templete 1

![Yii2 formCompleteRatio screenshot_temp1](http://2nees.com/github/formCompleteRatio/2.png)

## Screenshot for widjet when you setup this code for templete 2

![Yii2 formCompleteRatio screenshot_temo2](http://2nees.com/github/formCompleteRatio/3.png)

## Features

1. Calclate Ratio For Forms/Models Filled And Saved In Database
2. Work On Relational Forms/Models
3. You have an option to determind needed field to calclate ratio.
4. You have an option to determind result style as a number only, number with %, or template.
5. You have an option to determind group of fields to calcalte ratio if any one of them is fill add ratio like all this group is fill.(Note: this group will get weight like 1 field only).
6. You have an option to git ratio for one or more of rows from relational table.
7. Work on basic & advance yii2 templete

## Decencies

1. Yii2
2. Twitter bootstrap assets

## Installation:
The preferred way to install this extension is through [composer](https://getcomposer.org/).

Either run

`php composer.phar require --prefer-dist aneeshikmat/form-complete-ratio "*@dev"`

or add

`"aneeshikmat/form-complete-ratio": "*@dev"`

to the require section of your `composer.json` file.

For advance template you need to set this widjet in common directory, and the path style will be like this:
> yii2Advance/common/widgets/formCompleteRatio

For Basic templete, set this widjet in this path(if current path not exsists create it manually)
> yii2basic/common/widgets/formCompleteRatio

And then Add this line '@common' => '@app/common' to 'config/web.php' under 'aliases'.

## Usage
To use this widjet you need to add this code to your view: 
```
/* you need to add needed field in you model to calclate ratio, In our example these field in Signup() model */
public $formRatioField = [
        'id', 'name', 'email', 'phone', 'street'....etc
    ];

use common\widgets\FormCompleteRatio\FormCompleteRatio;// on top view page
<?= FormCompleteRatio::widget([
    'mainModel'         => new Signup(),
])?>

```
As you see, its very simple, and now we will be explan this code, and then go to display all option may be use to help us,
In prev code we create FormCompleteRatio widget, **mainModel** is used to determind the model or form we need to calclate ratio for it, Signup here is an model, and in this example we assign new model and thats mean we will get 0 ratio.
Look at this is image for result:

![Yii2 formCompleteRatio screenshot_new_model](http://2nees.com/github/formCompleteRatio/4.png)

Second option is used when we need to get ratio, so that we need to find needed record for current user, let us see this example:
```
<?= FormCompleteRatio::widget([
            'mainModel'         => Signup::findOne(['id' => 1]),
            'withPercentage'    => true,
        ])?>
```

As you see, we use findOne, and we use **withPercentage** to set % after ratio number.
Look at this image for result: 

![Yii2 formCompleteRatio screenshot_update_model](http://2nees.com/github/formCompleteRatio/5.png)

And now let us to see all posiople option we can use it:
```
<?= FormCompleteRatio::widget([
            'mainModel'         => Signup::findOne(['id' => 1]),
            'templateStyle'     => 1,
            'withPercentage'    => true,
            'formRatioField'            => ['id', 'name', 'email', 'phone'],
            'ignoreMainModelRatioField' => true,
            'templateOption'    => [
                'templateClassWrapper' => 'col-xs-4',// Block Class
                'templateBlockId'      => 'form-complete-ratio',
                'urlText'              => 'Update',// Url Text
                'url'                  => 'javascript:void(0);',// Url
                'title'                => 'Nice Option',// Main Block Title
            ]
        ])?>
```

**templateStyle**: This option has 3 def value (0, 1, 2) and the def option is 0 and thats mean without any template, 1 will render simple templete like image in "Screenshot for widjet when you setup this code for templete 1", and 2 will render simplte templete like image in "Screenshot for widjet when you setup this code for templete 2", and dependace of these option you can edit or update any style you need.

**withPercentage**: This option can be false or true, and thats mean concat % with ratio number or no, the def option is false, and true for template 1 only

**templateOption**: This option has an options may be use to custmize templete 1, or template 2.

**formRatioField**: This option is very important and one of main option in this widjet, we can set this option dirctly in widjet to determind field, or we can set it in our model without invoke it in widjet, so that you can override the field ratio or use init field set in model...but if you set it in wedjit you need to set **ignoreMainModelRatioField** true.
**formRatioField** is accept only array, and this array may has these option like: 
1) ['field1', 'field2',....etc]:in this style our class will check if all field set here is fill or no, if 3 from 4 is full our class will return 75%.

2) ['field1', ['field2', 'field3']]: in this style we set nested array, and thats mean if field2 **OR** field3 is fill then field2 and field 3 is fill, in other word we can say field1 is weight 1, and field2 & field3 weight 1, so that if field2 is fill by user without fill field1 and field3 the ratio will be 50%, this case usfall in many case such as if user has social media links and if he set facebook or tw will be ok to display a message "your profile is complete".

3) ['field-1', ['model' => '/dir/ModelClassName', 'conditions' => ['field_db_name' => val]]]: in this style we need to calclate ratio with relational model, 'model' will contion a class path like \app\models\SocialMedia, and conditions have a rule we need to set to get needed row such as git relational rows if is_deleted = 0..etc, you can also use {{id}} in condtions val as a replacmnets for id for mainModel, its usfall when you try to render relational rows dependacne of FK..or any other else, also in this style we  will calclate ratio just if we find model row without checking field in this model, if you need to calclate ratio dependace of relational field ..go to next point.

4) ['id', 'name', 'email', 'phone', ['model' => '\app\models\SocialMedia', 'oneOrMore' => 'more', 'modelItem' => [['tw', 'fb'], 'website'], 'conditions' => ['signup_id' => '{{id}}']]]: in this style we add **oneOrMore** to determind the ratio will calclate dependance of all rows found in model or just for one row..so that you have two option **more** for all rows, **one** only for fetch field from one row only, also if you use **oneOrMore** you need to use **modelItem**, this option has an array of fields like point 1 or 2.


to downlaod simple fully demo you can access this url:
http://2nees.com/formCompleteRatio.php

and this is screenshot for demo: 
![Yii2 formCompleteRatio screenshot_new_model](http://2nees.com/github/formCompleteRatio/6.png)
