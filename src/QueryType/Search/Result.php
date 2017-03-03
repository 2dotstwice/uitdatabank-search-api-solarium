<?php

namespace TwoDotsTwice\UiTDBSearchSolarium\QueryType\Search;

use CultureFeed_Cdb_Xml;
use SimpleXMLElement;
use Solarium\QueryType\Select\Result\Result as BaseResult;

class Result extends BaseResult
{
    public function getData()
    {
        /** @var Query $query */
        $query = $this->getQuery();
        $cdbXmlVersion = $query->getCdbXmlVersion();
        if (null === $this->data) {
            $this->data = simplexml_load_string(
                $this->response->getBody(),
                SimpleXMLElement::class,
                0,
                CultureFeed_Cdb_Xml::namespaceUriForVersion($cdbXmlVersion)
            );
        }

        return $this->data;
    }
}
