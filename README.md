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
