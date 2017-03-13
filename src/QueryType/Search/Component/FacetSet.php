<?php
/**
 * @file
 */

namespace TwoDotsTwice\UiTDBSearchSolarium\QueryType\Search\Component;


use TwoDotsTwice\UiTDBSearchSolarium\QueryType\Search\Component\ResponseParser\FacetSet as ResponseParser;
use TwoDotsTwice\UiTDBSearchSolarium\QueryType\Search\Component\RequestBuilder\FacetSet as RequestBuilder;
use Solarium\QueryType\Select\Query\Component\FacetSet as FacetSetBase;

class FacetSet extends FacetSetBase {

  public function getRequestBuilder() {
    return new RequestBuilder();
  }

  public function getResponseParser() {
    return new ResponseParser();
  }

}
