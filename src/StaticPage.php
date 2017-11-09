<?php
namespace VladimirBiro\StPage;

use Nette\Database\Context;


/**
 * Generates random color
 *
 * @author Milan Herda <perun@perunhq.org>
 */
class StaticPage
{
    /** @var Context */
    private $database;

    const DEFAULT_ARTICLE_TABLE = 'static_page';

    private $staticPageList,
            $staticPage;

    // Defaultne hodnoty
    private $idWeb = null;
    private $isPublic = 1;



    /**
     * ArticleManager constructor.
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        $this->database = $context;
    }



    public function setStaticPageList()
    {
        $r = $this->database->table(self::DEFAULT_ARTICLE_TABLE);

        if ($this->idWeb) {
            $r->where('id_web', $this->idWeb);
        }

        if ($this->isPublic) {
            $r->where('is_public', $this->idWeb);
        }

        $this->staticPageList = $r;
    }

    public function getStaticPageList()
    {
        return $this->staticPageList;
    }



    public function setStaticPageById($id)
    {
        $this->staticPage = $this->database->table(self::DEFAULT_ARTICLE_TABLE)->get($id);
    }

    public function getStaticPage()
    {
        return $this->staticPage;
    }



    public function editStaticPage($param)
    {
        return $this->getStaticPage()->update($param);
    }



    public function addStaticPage($param)
    {
        if ($this->idWeb) {
            $param['id_web'] = $this->idWeb;
        }
        return $this->database->table(self::DEFAULT_ARTICLE_TABLE)->insert($param);
    }



    public function deleteStaticPage()
    {
        if (!$r = $this->getStaticPage()) {
            return false;
        }
        return $r->delete();
    }



    public function setIdWeb($idWeb)
    {
        $this->idWeb = $idWeb;
    }

    public function getIdWeb()
    {
        return $this->idWeb;
    }



    public function setIsPublic($isPublic)
    {
        $this->isPublic = ($isPublic == 0) ? 0 : 1;
    }

    public function getIsPublic()
    {
        return $this->isPublic;
    }
}