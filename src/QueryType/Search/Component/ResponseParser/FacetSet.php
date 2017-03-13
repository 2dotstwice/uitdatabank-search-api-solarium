<?php

namespace TwoDotsTwice\UiTDBSearchSolarium\QueryType\Search\Component\ResponseParser;

use SimpleXMLElement;
use Solarium\Exception\RuntimeException;
use Solarium\QueryType\Select\ResponseParser\Component\FacetSet as FacetSetBase;
use TwoDotsTwice\UiTDBSearchSolarium\QueryType\Search\Component\FacetSet as QueryFacetSet;
use Solarium\QueryType\Select\Result\FacetSet as ResultFacetSet;
use TwoDotsTwice\UiTDBSearchSolarium\QueryType\Search\Query;

class FacetSet extends FacetSetBase {
  /**
   * Parse result data into result objects.
   *
   * @throws RuntimeException
   *
   * @param Query             $query
   * @param QueryFacetSet     $facetSet
   * @param SimpleXMLElement $data
   *
   * @return ResultFacetSet
   */
  public function parse($query, $facetSet, $data)
  {
    $facets = [];

    foreach ($facetSet->getFacets() as $facet) {

    }

    if (!empty($data->facets)) {
      /** @var \SimpleXMLElement $facetElement */
      foreach ($data->facets->facet as $facetElement) {
        $facetAttributes = $facetElement->attributes();
        $field = (string) $facetAttributes['field'];

        // Category is a special facet. This is a fake facet that returns
        // all the results for every possible category facet.
        // Map it to the correct facet.
        if ($field == 'category') {
          $field = 'category_' . $facetAttributes['domain'] . '_id';
          if (!isset($facets[$field])) {
            $facets[$field] = new Facet($field, new FacetField($field));
          }
        }
        if (isset($facets[$field])) {
          /** @var Facet $facet */
          $facet = $facets[$field];
          $item = $this->createResultItem($facetElement);
          $this->createFacetResultSubItems($facetElement, $item);
          $facet->getResult()->addItem($item);
        }
      }
    }
    return $facets;
  }

    return $this->createFacetSet($facets);
  }
}