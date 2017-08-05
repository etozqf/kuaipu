<?php

class plugin_classify extends object
{
    protected $_model;

    protected $_db;

    protected $_model_bind;

    function __construct(&$model)
    {
        $this->_db = factory::db();
        $this->_model = $model;
        $this->_model_bind = loader::model('admin/mobile_content_classify', 'mobile');
    }

    function after_add()
    {
        $this->_update_classifyid();
    }

    function after_edit()
    {
        $this->_update_classifyid();
    }

    function after_get()
    {
        $contentid = $this->_model->contentid;
        if ($contentid) {
            $this->_model->data['classifyids'] = implode(',', $this->_model_bind->gets_field('classifyid', array(
                'contentid' => $contentid
            )));
        }
    }

    protected function _update_classifyid()
    {
        $contentid = $this->_model->contentid;
        if (!$contentid) {
            throw new Exception('内容ID不正确');
        }

        $classifyids = id_format(value($this->_model->data, 'classifyid'));
        if ($classifyids) {
            $classifyids = (array) $classifyids;
            $orig_classifyids = $this->_model_bind->gets_field('classifyid', array(
                'contentid' => $contentid
            ));

            $priv_classifyids = array();
            $classifys = mobile_classify(value($this->_model->data, 'modelid'), true);
            if (count($classifys)) {
                $ids = array();
                foreach ($classifys as &$classify) {
                    $priv_classifyids[] = $classify['classifyid'];
                }
            }
            if (count($orig_classifyids)) {
                // 原来有频道
                $diff_add_classifyids = array_diff($classifyids, $orig_classifyids);
                $diff_removed_classifyids = array_diff($orig_classifyids, $classifyids);
                if (count($diff_removed_classifyids)) {
                    $diff_allow_removed_classifyids = array_intersect($diff_removed_classifyids, $priv_classifyids);
                    if (count($diff_allow_removed_classifyids)) {
                        foreach ($diff_allow_removed_classifyids as $classifyid) {
                            $this->_model_bind->delete(array(
                                'contentid' => $contentid,
                                'classifyid' => $classifyid
                            ));
                            $this->_update_category($classifyid);
                        }
                    }
                }
                if (count($diff_add_classifyids)) {
                    $diff_allow_add_classifyids = array_intersect($diff_add_classifyids, $priv_classifyids);
                    if (count($diff_allow_add_classifyids)) {
                        foreach ($diff_allow_add_classifyids as $classifyid) {
                            $this->_model_bind->insert(array(
                                'contentid' => $contentid,
                                'classifyid' => $classifyid
                            ));
                            $this->_update_category($classifyid);
                        }
                    }
                }
            } else {
                // 原来没有频道
                if ($priv_classifyids) {
                    $classifyids = array_intersect($classifyids, $priv_classifyids);
                }
                if (count($classifyids)) {
                    foreach ($classifyids as $classifyid) {
                        $this->_model_bind->insert(array(
                            'contentid' => $contentid,
                            'classifyid' => $classifyid
                        ));
                        $this->_update_category($classifyid);
                    }
                }
            }
        }
    }

    protected function _update_category($classifyid)
    {
        // 更新 sorttime
        $this->_db->update("UPDATE `#table_mobile_classify` SET `sorttime` = ? WHERE `classifyid` = ?", array(TIME, $classifyid));
    }
}