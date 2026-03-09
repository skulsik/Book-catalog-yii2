<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $book_id
 * @property string $path
 * @property int $sort
 * @property Book $book
 */
class BookImage extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%book_image}}';
    }

    public function rules(): array
    {
        return [
            [['book_id', 'path'], 'required'],
            [['book_id', 'sort'], 'integer'],
            [['path'], 'string', 'max' => 255],
            [['book_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Book::class,
                'targetAttribute' => ['book_id' => 'id']
            ]
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'book_id' => 'Книга',
            'path' => 'Путь к изображению',
            'sort' => 'Сортировка'
        ];
    }

    /**
     * Связь с книгой
     */
    public function getBook(): ActiveQuery
    {
        return $this->hasOne(Book::class, ['id' => 'book_id']);
    }
}
