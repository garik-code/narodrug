<?php
/* This file has been auto-generated. Do not edit this file directly. */

abstract class Sabai_Addon_System_Model_Base_Route extends SabaiFramework_Model_Entity
{
    public function __construct(SabaiFramework_Model $model)
    {
        parent::__construct('Route', $model);
        $this->_vars = array('route_path' => null, 'route_method' => null, 'route_format' => null, 'route_controller' => null, 'route_controller_addon' => null, 'route_forward' => null, 'route_addon' => null, 'route_type' => 0, 'route_class' => null, 'route_access_callback' => false, 'route_title_callback' => false, 'route_callback_path' => null, 'route_callback_addon' => null, 'route_title' => null, 'route_description' => null, 'route_weight' => 0, 'route_depth' => 0, 'route_ajax' => 0, 'route_priority' => 5, 'route_data' => null, 'route_id' => 0, 'route_created' => 0, 'route_updated' => 0);
    }

    public function __clone()
    {
        $this->_vars = array('route_id' => 0, 'route_created' => 0, 'route_updated' => 0) + $this->_vars;
    }

    public function __toString()
    {
        return $this->__get('path');
    }

    public function __get($name)
    {
        if ($name === 'path')
            return $this->_vars['route_path'];
        elseif ($name === 'method')
            return $this->_vars['route_method'];
        elseif ($name === 'format')
            return $this->_vars['route_format'];
        elseif ($name === 'controller')
            return $this->_vars['route_controller'];
        elseif ($name === 'controller_addon')
            return $this->_vars['route_controller_addon'];
        elseif ($name === 'forward')
            return $this->_vars['route_forward'];
        elseif ($name === 'addon')
            return $this->_vars['route_addon'];
        elseif ($name === 'type')
            return $this->_vars['route_type'];
        elseif ($name === 'class')
            return $this->_vars['route_class'];
        elseif ($name === 'access_callback')
            return $this->_vars['route_access_callback'];
        elseif ($name === 'title_callback')
            return $this->_vars['route_title_callback'];
        elseif ($name === 'callback_path')
            return $this->_vars['route_callback_path'];
        elseif ($name === 'callback_addon')
            return $this->_vars['route_callback_addon'];
        elseif ($name === 'title')
            return $this->_vars['route_title'];
        elseif ($name === 'description')
            return $this->_vars['route_description'];
        elseif ($name === 'weight')
            return $this->_vars['route_weight'];
        elseif ($name === 'depth')
            return $this->_vars['route_depth'];
        elseif ($name === 'ajax')
            return $this->_vars['route_ajax'];
        elseif ($name === 'priority')
            return $this->_vars['route_priority'];
        elseif ($name === 'data')
            return $this->_vars['route_data'];
        elseif ($name === 'id')
            return $this->_vars['route_id'];
        elseif ($name === 'created')
            return $this->_vars['route_created'];
        elseif ($name === 'updated')
            return $this->_vars['route_updated'];
        else
            return $this->fetchObject($name);
    }

    public function __set($name, $value)
    {
        if ($name === 'path')
            $this->_setVar('route_path', $value);
        elseif ($name === 'method')
            $this->_setVar('route_method', $value);
        elseif ($name === 'format')
            $this->_setVar('route_format', $value);
        elseif ($name === 'controller')
            $this->_setVar('route_controller', $value);
        elseif ($name === 'controller_addon')
            $this->_setVar('route_controller_addon', $value);
        elseif ($name === 'forward')
            $this->_setVar('route_forward', $value);
        elseif ($name === 'addon')
            $this->_setVar('route_addon', $value);
        elseif ($name === 'type')
            $this->_setVar('route_type', $value);
        elseif ($name === 'class')
            $this->_setVar('route_class', $value);
        elseif ($name === 'access_callback')
            $this->_setVar('route_access_callback', $value);
        elseif ($name === 'title_callback')
            $this->_setVar('route_title_callback', $value);
        elseif ($name === 'callback_path')
            $this->_setVar('route_callback_path', $value);
        elseif ($name === 'callback_addon')
            $this->_setVar('route_callback_addon', $value);
        elseif ($name === 'title')
            $this->_setVar('route_title', $value);
        elseif ($name === 'description')
            $this->_setVar('route_description', $value);
        elseif ($name === 'weight')
            $this->_setVar('route_weight', $value);
        elseif ($name === 'depth')
            $this->_setVar('route_depth', $value);
        elseif ($name === 'ajax')
            $this->_setVar('route_ajax', $value);
        elseif ($name === 'priority')
            $this->_setVar('route_priority', $value);
        elseif ($name === 'data')
            $this->_setVar('route_data', $value);
        elseif ($name === 'id')
            $this->_setVar('route_id', $value);
        else
            $this->assignObject($name, $value);
    }

    protected function _initVar($name, $value)
    {
        if ($name === 'route_format')
            $this->_vars['route_format'] = @unserialize($value);
        elseif ($name === 'route_type')
            $this->_vars['route_type'] = (int)$value;
        elseif ($name === 'route_access_callback')
            $this->_vars['route_access_callback'] = (bool)$value;
        elseif ($name === 'route_title_callback')
            $this->_vars['route_title_callback'] = (bool)$value;
        elseif ($name === 'route_weight')
            $this->_vars['route_weight'] = (int)$value;
        elseif ($name === 'route_depth')
            $this->_vars['route_depth'] = (int)$value;
        elseif ($name === 'route_ajax')
            $this->_vars['route_ajax'] = (int)$value;
        elseif ($name === 'route_priority')
            $this->_vars['route_priority'] = (int)$value;
        elseif ($name === 'route_data')
            $this->_vars['route_data'] = @unserialize($value);
        elseif ($name === 'route_id')
            $this->_vars['route_id'] = (int)$value;
        elseif ($name === 'route_created')
            $this->_vars['route_created'] = (int)$value;
        elseif ($name === 'route_updated')
            $this->_vars['route_updated'] = (int)$value;
        else
            $this->_vars[$name] = $value;
    }
}

abstract class Sabai_Addon_System_Model_Base_RouteRepository extends SabaiFramework_Model_EntityRepository
{
    public function __construct(SabaiFramework_Model $model)
    {
        parent::__construct('Route', $model);
    }

    protected function _getCollectionByRowset(SabaiFramework_DB_Rowset $rs)
    {
        return new Sabai_Addon_System_Model_Base_RoutesByRowset($rs, $this->_model->create('Route'), $this->_model);
    }

    public function createCollection(array $entities = array())
    {
        return new Sabai_Addon_System_Model_Base_Routes($this->_model, $entities);
    }
}

class Sabai_Addon_System_Model_Base_RoutesByRowset extends SabaiFramework_Model_EntityCollection_Rowset
{
    public function __construct(SabaiFramework_DB_Rowset $rs, Sabai_Addon_System_Model_Route $emptyEntity, SabaiFramework_Model $model)
    {
        parent::__construct('Routes', $rs, $emptyEntity, $model);
    }

    protected function _loadRow(SabaiFramework_Model_Entity $entity, array $row)
    {
        $entity->initVars($row);
    }
}

class Sabai_Addon_System_Model_Base_Routes extends SabaiFramework_Model_EntityCollection_Array
{
    public function __construct(SabaiFramework_Model $model, array $entities = array())
    {
        parent::__construct($model, 'Routes', $entities);
    }
}