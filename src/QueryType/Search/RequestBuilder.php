<?php

namespace TwoDotsTwice\UiTDBSearchSolarium\QueryType\Search;

use Solarium\Core\Client\Request;
use Solarium\Core\Query\AbstractRequestBuilder as BaseRequestBuilder;
use Solarium\Core\Query\QueryInterface;

/**
 * Build a search request.
 */
class RequestBuilder extends BaseRequestBuilder
{
    /**
     * Build request for a select query.
     *
     * @param QueryInterface|Query $query
     *
     * @return Request
     */
    public function build(QueryInterface $query)
    {
        $request = new Request();
        $request->setHandler($query->getHandler());
        $request->setParams($query->getParams());

        $group = $query->getGroup();
        if ($group) {
            $request->addParam('group', $group);
        }

        $version = $query->getCdbXMLVersion();
        $request->addParam('version', $version);

        // add basic params to request
        $request->addParam(
            'q',
            $this->renderLocalParams(
                $query->getQuery(),
                array('tag' => $query->getTags())
            )
        );
        $request->addParam('start', $query->getStart());
        $request->addParam('rows', $query->getRows());

        // add sort fields to request
        $sort = array();
        foreach ($query->getSorts() as $field => $order) {
            $sort[] = $field . ' ' . $order;
        }
        if (count($sort) !== 0) {
            $request->addParam('sort', implode(',', $sort));
        }

        $filterQueries = $query->getFilterQueries();
        if (count($filterQueries) !== 0) {
            foreach ($filterQueries as $filterQuery) {
                $fq = $this->renderLocalParams(
                    $filterQuery->getQuery(),
                    array('tag' => $filterQuery->getTags())
                );
                $request->addParam('fq', $fq);
            }
        }

        foreach ($query->getComponents() as $component) {
            $componentBuilder = $component->getRequestBuilder();
            if ($componentBuilder) {
                $request = $componentBuilder->buildComponent(
                    $component,
                    $request
                );
            }
        }

        return $request;
    }
}
