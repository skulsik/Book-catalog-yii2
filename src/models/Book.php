<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Book extends ActiveRecord
{
    public static function tableName() { return '{{%book}}'; }

    public function behaviors() { return [TimestampBehavior::class]; }

    public function rules() {
        return [
            [['title','year'], 'required'],
            [['year'], 'integer'],
            [['description'], 'string'],
            [['title','cover_image'], 'string','max'=>255],
            [['isbn'],'string','max'=>32],
            [['isbn'],'unique'],
        ];
    }

    public function getAuthors() {
        return $this->hasMany(Author::class,['id'=>'author_id'])->viaTable('{{%book_author}}',['book_id'=>'id']);
    }
}