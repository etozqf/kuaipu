<?php

class plugin_cache extends object
{
    protected $_model;

    protected $_db;

    protected $_model_bind;

    function __construct(&$model)
    {
        $this->_db = factory::db();
        $this->_model = $model;
    }

    function after_add()
    {
        $this->list_cache();
        $this->content_cache();
    }

    function after_edit()
    {
        $this->list_cache();
        $this->content_cache();
    }

    function after_delete()
    {
        $this->update_cache();
        $this->delete_cache();
    }

    function after_remove()
    {

        $this->update_cache();
    }

    function after_restore()
    {
        $this->update_cache();
    }

    function after_bumpup()
    {
        $this->update_cache();
    }

    function after_unpublish()
    {
        $this->update_cache();
    }

    function after_pass()
    {
        $this->update_cache();
    }

    function after_publish()
    {
        $this->update_cache();
    }

    protected function list_cache()
    {
        $cache = Factory::cache();
        $catids = id_format(value($this->_model->data, 'catid'));
        $classifyids = id_format(value($this->_model->data, 'classifyid'));

        if($catids) {
            if (!is_array($catids)) {
                $catids = array($catids);
            }
            foreach ($catids as $catid) {
                $total = $catdata = $this->_db->get("SELECT count(*) as total FROM #table_mobile_content as c, #table_mobile_content_category as cc WHERE c.contentid=cc.contentid AND cc.catid=".$catid." AND c.status=6 ORDER BY c.published DESC");
                $catdata = $this->_db->select("SELECT c.* FROM #table_mobile_content as c, #table_mobile_content_category as cc WHERE c.contentid=cc.contentid AND cc.catid=".$catid." AND c.status=6 ORDER BY c.published DESC LIMIT 0,60");
                foreach ($catdata as &$value) {
                    if ($value['topicid']) {
                        $value['comments'] = table('comment_topic', $value['topicid'], 'comments');
                    }
                }
                if ($catdata) {
                    $catdatas['total'] = $total['total'] ? intval($total['total']) : 0;
                    $catdatas['data'] = $catdata;
                    $cache->set("mobile:cache:list:category:".md5($catid), json_encode($catdatas));
                }

                $articletotal = $catdata = $this->_db->get("SELECT count(*) as total FROM #table_mobile_content as c, #table_mobile_content_category as cc WHERE c.contentid=cc.contentid AND cc.catid=".$catid." AND c.status=6 AND c.modelid=1 ORDER BY c.published DESC");
                $articlecatdata = $this->_db->select("SELECT c.* FROM #table_mobile_content as c, #table_mobile_content_category as cc WHERE c.contentid=cc.contentid AND cc.catid=".$catid." AND c.status=6 AND c.modelid=1 ORDER BY c.published DESC LIMIT 0,60");
                foreach ($articlecatdata as &$articlevalue) {
                    if ($articlevalue['topicid']) {
                        $articlevalue['comments'] = table('comment_topic', $articlevalue['topicid'], 'comments');
                    }
                }
                if ($articlecatdata) {
                    $articlecatdatas['total'] = $articletotal['total'] ? intval($articletotal['total']) : 0;
                    $articlecatdatas['data'] = $articlecatdata;
                    $cache->set("mobile:cache:list:article:" . md5($catid), json_encode($articlecatdatas));
                }
            }
        }
        if($classifyids) {
            if (!is_array($classifyids)) {
                $classifyids = array($classifyids);
            }
            foreach ($classifyids as $classifyid) {
                $total = $this->_db->get("SELECT count(*) as total FROM #table_mobile_content as c, #table_mobile_content_classify as cc WHERE c.contentid=cc.contentid AND cc.classifyid=".$classifyid." AND c.status=6 ORDER BY c.published DESC");
                $classdata = $this->_db->select("SELECT c.* FROM #table_mobile_content as c, #table_mobile_content_classify as cc WHERE c.contentid=cc.contentid AND cc.classifyid=".$classifyid." AND c.status=6 ORDER BY c.published DESC LIMIT 0,60");
                foreach ($classdata as &$value) {
                    if ($value['topicid']) {
                        $value['comments'] = table('comment_topic', $value['topicid'], 'comments');
                    }
                }
                if ($classdata) {
                    $classdatas['total'] = $total['total'] ? intval($total['total']) : 0;
                    $classdatas['data'] = $classdata;
                    $cache->set("mobile:cache:list:classify:".md5($classifyid), json_encode($classdatas));
                }
            }
        }
    }

    protected function update_cache()
    {
        $cache = Factory::cache();

        $contentid = intval($this->_model->contentid);
        $modelid = table('mobile_content', $contentid, 'modelid');
        if ($modelid == 11) {
            $modelname = 'evenlive';
        } else {
            $modelname = table('model', $modelid, 'alias');
        }
        $model = loader::model('admin/mobile_'.$modelname, 'mobile');
        $data = $model->get($contentid);
        $catids = id_format(value($data, 'catids'));
        $classifyids = id_format(value($data, 'classifyids'));

        if($catids) {
            if (!is_array($catids)) {
                $catids = array($catids);
            }
            foreach ($catids as $catid) {
                $total = $catdata = $this->_db->get("SELECT count(*) as total FROM #table_mobile_content as c, #table_mobile_content_category as cc WHERE c.contentid=cc.contentid AND cc.catid=".$catid." AND c.status=6 ORDER BY c.published DESC");
                $catdata = $this->_db->select("SELECT c.* FROM #table_mobile_content as c, #table_mobile_content_category as cc WHERE c.contentid=cc.contentid AND cc.catid=".$catid." AND c.status=6 ORDER BY c.published DESC LIMIT 0,60");
                foreach ($catdata as &$value) {
                    if ($value['topicid']) {
                        $value['comments'] = table('comment_topic', $value['topicid'], 'comments');
                    }
                }
                if ($catdata) {
                    $catdatas['total'] = $total['total'] ? intval($total['total']) : 0;
                    $catdatas['data'] = $catdata;
                    $cache->set("mobile:cache:list:category:".md5($catid), json_encode($catdatas));
                }
            }
        }
        if($classifyids) {
            if (!is_array($classifyids)) {
                $classifyids = array($classifyids);
            }
            foreach ($classifyids as $classifyid) {
                $total = $this->_db->get("SELECT count(*) as total FROM #table_mobile_content as c, #table_mobile_content_classify as cc WHERE c.contentid=cc.contentid AND cc.classifyid=".$classifyid." AND c.status=6 ORDER BY c.published DESC");
                $classdata = $this->_db->select("SELECT c.* FROM #table_mobile_content as c, #table_mobile_content_classify as cc WHERE c.contentid=cc.contentid AND cc.classifyid=".$classifyid." AND c.status=6 ORDER BY c.published DESC LIMIT 0,60");
                foreach ($classdata as &$value) {
                    if ($value['topicid']) {
                        $value['comments'] = table('comment_topic', $value['topicid'], 'comments');
                    }
                }
                if ($classdata) {
                    $classdatas['total'] = $total['total'] ? intval($total['total']) : 0;
                    $classdatas['data'] = $classdata;
                    $cache->set("mobile:cache:list:classify:".md5($classifyid), json_encode($classdatas));
                }
            }
        }
    }

    protected function content_cache()
    {
        $cache = Factory::cache();
        $modelid = intval(value($this->_model->data, 'modelid'));
        $contentid = intval($this->_model->contentid);

        if ($modelid == 11) {
            $modelname = 'evenlive';
        } else {
            $modelname = table('model', $modelid, 'alias');
        }
        $model = loader::model('admin/mobile_'.$modelname, 'mobile');
        $data = $model->get($contentid);
        $data['comments'] = $data['reference']['comments'];
        $cache->set("mobile:cache:content:".$modelname.":".md5($contentid), json_encode($data));

    }

    protected function delete_cache()
    {
        $cache = Factory::cache();
        $modelid = intval(value($this->_model->data, 'modelid'));
        $contentid = intval(value($this->_model->data, 'contentid'));

        if ($modelid == 11) {
            $modelname = 'evenlive';
        } else {
            $modelname = table('model', $modelid, 'alias');
        }
        $cache->rm("mobile:cache:content:".$modelname.":".md5($contentid));

    }
}