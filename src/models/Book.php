<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Book
 *
 * @property int $id
 * @property string $title
 * @property int $year
 * @property string|null $description
 * @property string|null $isbn
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * Relations
 * @property Author[] $authors
 * @property BookImage[] $images
 * @property BookImage|null $cover
 */
class Book extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%book}}';
    }

    public function behaviors(): array
    {
        return [TimestampBehavior::class];
    }

    public function rules(): array
    {
        return [
            [['title','year'], 'required'],
            [['year'], 'integer'],
            [['description'], 'string'],
            [['title'], 'string','max'=>255],
            [['isbn'],'string','max'=>32],
            [['isbn'],'unique'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Название книги',
            'year' => 'Год выпуска',
            'description' => 'Описание',
            'isbn' => 'Уникальный номер книги'
        ];
    }

    /**
     * Авторы книги
     */
    public function getAuthors(): ActiveQuery
    {
        return $this->hasMany(Author::class,['id'=>'author_id'])->viaTable('{{%book_author}}',['book_id'=>'id']);
    }

    /**
     * Изображения книги
     */
    public function getImages(): ActiveQuery
    {
        return $this->hasMany(BookImage::class, ['book_id' => 'id']);
    }

    /**
     * Обложка книги
     */
    public function getCover(): ActiveQuery
    {
        return $this->hasOne(BookImage::class, ['book_id' => 'id'])
            ->orderBy(['sort' => SORT_ASC]);
    }

    public function beforeDelete(): bool
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        $this->unlinkAll('authors', true);

        foreach ($this->images as $image) {
            $image->delete();
        }

        return true;
    }
}
