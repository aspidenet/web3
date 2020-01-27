<?php
//  
// Copyright (c) ASPIDE.NET. All rights reserved.  
// Licensed under the GPLv3 License. See LICENSE file in the project root for full license information.  
//  
// SPDX-License-Identifier: GPL-3.0-or-later
//


class ClassType extends Base {
    
    function __construct($code) {
        parent::__construct();
        
        $db = getDB();
        $sql = "SELECT * FROM MetaClassTypes WHERE classtype_code=?";
        $rs = $db->Execute($sql, array($code));
        $row = $rs->GetRow();
        $this->_fields = $row;
    }
    
    #--------------------------------------------------------
    
    public function nodes($parent='root') {
        $db = getDB();
        $sql = "SELECT * FROM MetaClassNodes WHERE classtype_code=? AND parent_code=? ORDER BY sorting";
        $rs = $db->Execute($sql, array($this->_fields["classtype_code"], $parent));
        $rows = $rs->GetArray();
        $nodes = array();
        foreach($rows as $item) {
            $value = $item["node_code"];
            $label = $item["label0"];
            $nodes[$value] = $label;
        }
        return $nodes;
    }
    
    // public function display($action='R', $value=null) {
    // }

}