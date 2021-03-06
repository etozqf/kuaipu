<?php

class plugin_fields extends object
{
    private $activity, $template, $selected = array(), $required = array(), $displayed = array();

    public function __construct($activity)
    {
        $this->activity = $activity;
    }

    public function before_add()
    {
        $this->tostring();
    }

    public function before_edit()
    {
        $this->tostring();
    }

    public function after_get()
    {
        $this->stringto();
    }

    public function html_write()
    {
        $this->stringto();
    }

    private function tostring()
    {
        foreach ($this->activity->data['fields'] as $key => $value) {
            $this->selected[] = $key;
            if ($value['need']) $this->required[] = $key;
            if ($value['display']) $this->displayed[] = $key;
        }

        $this->activity->data['selected'] = !empty($this->selected) ? implode(',', $this->selected) : '';
        $this->activity->data['required'] = !empty($this->required) ? implode(',', $this->required) : '';
        $this->activity->data['displayed'] = !empty($this->displayed) ? implode(',', $this->displayed) : '';
    }

    private function stringto()
    {
        loader::import('lib.activityField', app_dir('activity'));

        $this->selected = !empty($this->activity->data['selected']) ? explode(',', $this->activity->data['selected']) : '';
        $this->required = !empty($this->activity->data['required']) ? explode(',', $this->activity->data['required']) : '';
        $this->displayed = !empty($this->activity->data['displayed']) ? explode(',', $this->activity->data['displayed']) : '';
        if (!empty($this->selected)) {
            foreach ($this->selected as $key => $value) {
                $field = activityField::parseField($value);
                if (empty($field))
                {
                    unset($this->selected[$key]);
                    continue;
                }
                $this->activity->data['fields'][$value] = array_merge($field, array(
                    'have' => 1
                ));
            }
        }
        if (!empty($this->required)) {
            foreach ($this->required as $key => $value) {
                // 只有 selected 字段才可以 need
                if (isset($this->activity->data['fields'][$value])) {
                    $this->activity->data['fields'][$value]['need'] = 1;
                }
            }
        }
        if (!empty($this->displayed)) {
            foreach ($this->displayed as $key => $value) {
                // 只有 selected 字段才可以 display
                if (isset($this->activity->data['fields'][$value])) {
                    $this->activity->data['fields'][$value]['display'] = 1;
                }
            }
        }
    }
}