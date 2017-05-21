<?php

namespace Models\Form;

class Form {

    protected $rulesArr;
    protected $fields;

    

    public function validateFields($data) {
        foreach ($data as $field_name => $field_value) {
            $rules = $this->rulesArr[$field_name];
            foreach ($rules as $rule) {
                switch ($rule) {
                    case 'required':
                        if (!$val) {
                            $this->fields["errors"][$field][] = $rule;
                        }
                        break;
                    case 'min':
                        if (mb_strlen($val) < $condition) {
                            $this->fields["errors"][$field][] = $rule;
                        }
                        break;
                    case 'max':
                        if (mb_strlen($val) > $condition) {
                            $this->fields["errors"][$field][] = $rule;
                        }
                        break;
                    case 'equivalent':
                        if ($val != $data[$condition]) {
                            $this->fields["errors"][$field][] = $rule;
                        }
                        break;
                    case 'type' :
                        if (!filter_var($val, FILTER_VALIDATE_EMAIL)) {
                            $this->fields["errors"][$field][] = $rule;
                        }
                };
            }

            return (empty($this->fields["errors"]));
        }
    }

    public function validate($data) {
        foreach ($this->rulesArr as $field => $rules) {
            $val = $data[$field];
            foreach ($rules as $rule => $condition) {
                switch ($rule) {
                    case 'required':
                        if (!$val) {
                            $this->fields["errors"][$field][] = $rule;
                        }
                        break;
                    case 'min':
                        if (mb_strlen($val) < $condition) {
                            $this->fields["errors"][$field][] = $rule;
                        }
                        break;
                    case 'max':
                        if (mb_strlen($val) > $condition) {
                            $this->fields["errors"][$field][] = $rule;
                        }
                        break;
                    case 'equivalent':
                        if ($val != $data[$condition]) {
                            $this->fields["errors"][$field][] = $rule;
                        }
                        break;
                    case 'type' :
                        if (!filter_var($val, FILTER_VALIDATE_EMAIL)) {
                            $this->fields["errors"][$field][] = $rule;
                        }
                };
            }
        }
        return (empty($this->fields["errors"]));
    }

    public function getFields() {
        return $this->fields;
    }

}
