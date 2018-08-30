# formCompleteRatio

formCompleteRatio Widget for yii2, to Calculate ratio for any form filled by user (Profile Complete Ratio As Example)

## Screenshot from real project

![Yii2 formCompleteRatio screenshot_t1](http://2nees.com/github/formCompleteRatio/1.png)

## Screenshot for widjet when you setup this code for templete 1

![Yii2 formCompleteRatio screenshot_temp1](http://2nees.com/github/formCompleteRatio/2.png)

## Screenshot for widjet when you setup this code for templete 2

![Yii2 formCompleteRatio screenshot_temo2](http://2nees.com/github/formCompleteRatio/3.png)

## Features

1. Calculate Ratio For Forms/Models Filled And Saved In Database
2. Work On Relational Forms/Models
3. You have an option to determine needed fields to Calculate ratio.
4. You have an option to determine the result style as a number only, number with %, or a template.
5. You have an option to determine group of fields to Calculate ratio if any one of them is filled add ratio like all the group is filled.(Note: this group will get weight as 1 field only).
6. You have an option to get ratio for one or more of rows from relational table.
7. Works on basic & advance yii2 templete

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

## Usage
To use this widjet you need to add this code to your view:

```
/* you need to add needed field in your model to Calculate ratio, In our example these field in Signup() model */
public $formRatioField = [
        'id', 'name', 'email', 'phone', 'street'....etc
    ];

use aneeshikmat\yii2\FormCompleteRatio\FormCompleteRatio;// on top view page
<?= FormCompleteRatio::widget([
    'mainModel'         => new Signup(),
])?>
```

As you see, its very simple, and now we will be explaning this code, and then go to display all option may be use to help us,
In prev code we create FormCompleteRatio widget, **mainModel** is used to determind the model or form we need to Calculate ratio for it, Signup here is an model, and in this example we assign new model and thats mean we will get 0 ratio.
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


**templateStyle**: This option has 3 different value (0, 1, 2) and the default option is 0 and thats mean without any template, 1 will render simple templete like image in "Screenshot for widjet when you setup this code for templete 1", and 2 it will render simple templete like image in "Screenshot for widjet when you setup this code for templete 2", and the dependency of these options that you can edit or update to any style you need.

**withPercentage**: This option can be false or true, and it means concat % with ratio number or no, the different options is false, and true for template 1 only

**templateOption**: This option has an options may be used to custmize templete 1, or template 2.

**formRatioField**: This option is very important and one of the main options in this widjet, we can set this option directly in this widjet to the desired field, or we can set it in our model without invoking it , so that we can override the field ratio or use initiated field set in model...but if you set it in widjet you need to set **ignoreMainModelRatioField** to true.
**formRatioField** it accepts only array, and this array may have these options like: 
1) ['field1', 'field2',....etc]:in this style our class will check if all fields are filled or not, if 3 from 4 is filled our class will return a percentage 75%.

2) ['field1', ['field2', 'field3']]: in this style we set nested array, and that will mean if either field2 **OR** field3 is filled then field2 and field3 both is fill, in another word we can say field1 weight is 1, and field2 & field3 weight 1, so that if field2 is filled by user without filling field1 and  the ratio of field 2 and field3 will be 50%, its useful in many cases such as, if the user has a social media links and he  either set facebook or tw it will be ok to display a message "your profile is complete".

3) ['field-1', ['model' => '/dir/ModelClassName', 'conditions' => ['field_db_name' => val]]]: in this style we need to Calculate ratio with related models, the 'model' will contain a class path like \app\models\SocialMedia, and conditions will have a rule we need to set in order to get the needed row, to get the related rows like is_deleted = 0..etc, you can also use {{id}} in condtions val as a replacmnet for the id in mainModel, its useful when you try to render relationed rows depending on FK..or any other way, also in this style we  will Calculate ratio just if we find model row without checking field in this model, if you need to Calculate ratio dependacy of related fields ..go to the next point.

4) ['id', 'name', 'email', 'phone', ['model' => '\app\models\SocialMedia', 'oneOrMore' => 'more', 'modelItem' => [['tw', 'fb'], 'website'], 'conditions' => ['signup_id' => '{{id}}']]]: in this style we add **oneOrMore** to determie the ratio, we will Calculate the dependency of all rows found in model or just for one row..so that you have two options **more** for all rows, **one** only to fetch field from one row only, also if you use **oneOrMore** you need to use **modelItem**, this option has an array of fields like point 1 or 2.


> **to downlaod simple fully demo you can access this url:**
http://2nees.com/formCompleteRatio.php

and this is screenshot for demo: 
![Yii2 formCompleteRatio screenshot_new_model](http://2nees.com/github/formCompleteRatio/6.png)
