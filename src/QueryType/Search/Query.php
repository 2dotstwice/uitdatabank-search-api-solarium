<?php

namespace TwoDotsTwice\UiTDBSearchSolarium\QueryType\Search;

use Solarium\QueryType\Select\Query\Query as BaseQuery;
use TwoDotsTwice\UiTDBSearchSolarium\QueryType\Search\Component\FacetSet;

class Query extends BaseQuery
{
    protected $options = [
      'handler'        => 'search',
      'resultclass'    => Result::class,
      'documentclass'  => Document::class,
      'query'          => '*:*',
      'start'          => 0,
      'rows'           => 10,
      'cdbxml_version' => '3.3',
    ];

    protected $componentTypes = array(
      self::COMPONENT_FACETSET          => FacetSet::class,
    );

    protected $group;

    public function __construct($options = null)
    {
        parent::__construct($options);
    }

    /**
     * @param string $group
     *
     * @return self Provides fluent interface
     */
    public function setGroup($group)
    {
        $this->group = $group;

        return $this;
    }

    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Get a response parser for this query.
     *
     * @return ResponseParser
     */
    public function getResponseParser()
    {
        return new ResponseParser();
    }

    /**
     * Get a requestbuilder for this query.
     *
     * @return RequestBuilder
     */
    public function getRequestBuilder()
    {
        return new RequestBuilder();
    }

    public function getCdbXmlVersion()
    {
        return $this->getOption('cdbxml_version');
    }
}
