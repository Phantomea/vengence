<?php

namespace App\Model;

use Nette;
use App\Model;
use Nette\Database\Context;

class ArticleManager extends Nette\Object{

	protected $db;

	const TABLE_NAME = 'article',
                COLUMN_ID = 'article_id',
                COLUMN_TEXT = 'text',
                COLUMN_TITLE = 'title',
                COLUMN_PREVIEW = 'preview',
                COLUMN_PUBLISHED = 'published',
                COLUMN_AUTHOR = 'author_id';

	public function __construct(Context $db)
	{
		$this->db = $db;
	}

	public function getArticles()
	{
		return $this->db->table(self::TABLE_NAME)->order(self::COLUMN_ID)->fetchAll();
	}

	public function getArticle($id)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->fetch();
	}

	public function setArticle($data)
	{
		return $this->db->table(self::TABLE_NAME)->insert($data);
	}

	public function updateArticle($data)
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $data["".self::COLUMN_ID.""])->update($data);
	}

	public function deleteArticle($id) 
	{
		return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->delete();
	}
        
        /* Additional funcitons */
        
        public function getAuthorArticles($author_id)
        {
            return $this->db->table(self::TABLE_NAME)->where(self::COLUMN_AUTHOR, $author_id)->fetchAll();
        }
        
        
}