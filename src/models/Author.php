<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Author
 *
 * @property int $id
 * @property string $full_name
 *
 * Relations
 * @property Book[] $books
 */
class Author extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%author}}';
    }

    public function rules(): array
    {
        return [
            ['full_name', 'required'],
            ['full_name', 'string', 'max' => 255]
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'full_name' => 'Полное имя (ФИО)'
        ];
    }

    /**
     * Книги автора
     */
    public function getBooks(): ActiveQuery
    {
        return $this->hasMany(Book::class, ['id' => 'book_id'])->viaTable('{{%book_author}}', ['author_id' => 'id']);
    }
}
