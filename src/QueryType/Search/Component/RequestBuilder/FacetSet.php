<?php
/**
 * @file
 */

namespace TwoDotsTwice\UiTDBSearchSolarium\QueryType\Search\Component\RequestBuilder;

use Solarium\Core\Client\Request;
use Solarium\QueryType\Select\Query\Component\Facet\Field;
use Solarium\QueryType\Select\RequestBuilder\Component\FacetSet as FacetSetBase;

class FacetSet extends FacetSetBase {

  /**
   * Add params for a field facet to request.
   *
   * @param Request $request
   * @param Field $facet
   */
  public function addFacetField($request, $facet)
  {
    $field = $facet->getField();

    $request->addParam(
      'facetField',
      $this->renderLocalParams(
        $field,
        array('key' => $facet->getKey(), 'ex' => $facet->getExcludes())
      )
    );
  }
}