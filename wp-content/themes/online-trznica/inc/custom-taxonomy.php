<?php
/**
 * Created by PhpStorm.
 * User: ninomihovilic
 * Date: 25/05/16
 * Time: 10:24
 */


function getRegions($tax) {
    $regions = get_terms(array(
            'taxonomy' => $tax,
            "orderby"    => "count",
            'order' => 'DESC',
            "hide_empty" => false
        )
    );
    return $regions;
}

function getWineRegions() {
    $regions = get_terms(array(
            'taxonomy' => 'wine-regions',
            "orderby"    => "count",
            'order' => 'DESC',
            "hide_empty" => false
        )
    );
    return $regions;
}

function getRegionNames($region) {
    $city = '';
    if($region[1]) {
        foreach($region as $item) {
            if($item->parent != 0) {
                $city = $item->name;
            }
        }
    }
    return $city;
}

function getRegionsForQuery($regions, $tax) {
    $loc = array();
    if($regions) {
        foreach($regions as $item) {
            if($item == 0) {
                continue;
            }
            $term = get_term($item, $tax);
            $taxValue = array(
                'taxonomy' => $term->taxonomy,
                'field' => $term->name,
                'terms' => $term->term_id
            );
            array_push($loc, $taxValue);
        }
        return $loc;
    } else {
        return '';
    }

}

function getTypes() {
    $types = get_terms(array(
            'taxonomy' => 'type',
            "orderby"    => "count",
            'order' => 'DESC',
            "hide_empty" => false
        )
    );

    return $types;
}

function getWineTypes() {
    $types = get_terms(array(
            'taxonomy' => 'wine-type',
            "orderby"    => "count",
            'order' => 'DESC',
            "hide_empty" => false
        )
    );

    return $types;
}

function getTypeNames($types) {
    $typeString = '';
    if($types) {
        $type = array();
        foreach($types as $term) {
            array_push($type, $term->name);
        }
        $typeString = implode(", ", $type);
    }
    
    return $typeString;
}

function getTypeForQuery($types, $type) {
    $tax = array();
    foreach($types as $item) {
        if($item == 0) {
            continue;
        }
        $term = get_term($item, $type);
        $taxValue = array(
            'taxonomy' => $term->taxonomy,
            'field' => $term->name,
            'terms' => $term->term_id
        );
        array_push($tax, $taxValue);
    }
    
    return $tax;
}

function getTags() {
    $tags = get_terms(array(
            'taxonomy' => 'tags',
            "orderby"    => "count",
            'order' => 'DESC',
            "hide_empty" => false
        )
    );

    return $tags;
}

function getRegionParents($tax) {
    $regionParents = _get_term_hierarchy($tax);
    
    return $regionParents;
}

function getRegionChildren($id, $tax) {
    $locations = array();
    $region = get_term_children($id, $tax);
    foreach($region as $item) {
        $term = get_term($item, $tax);
        array_push($locations, $term);
    }
    usort($locations, "cmp");
    return $locations;
}

function cmp($a, $b)
{
    if ($a == $b) {
        return 0;
    }
    return ($a->count > $b->count) ? -1 : 1;
}



