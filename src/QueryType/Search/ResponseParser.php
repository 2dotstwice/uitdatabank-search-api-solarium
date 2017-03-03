<?php

namespace TwoDotsTwice\UiTDBSearchSolarium\QueryType\Search;

use CultureFeed_Cdb_Default;
use SimpleXMLElement;
use Solarium\Core\Query\ResponseParserInterface;
use Solarium\QueryType\Select\Result\Document;

class ResponseParser implements ResponseParserInterface
{
    public function parse($result)
    {
        $data = [];

        /** @var SimpleXMLElement $xml */
        $xml = $result->getData();

        $data['numfound'] = intval($xml->nofrecords);
        $data['documents'] = [];

        /** @var SimpleXMLElement $child */
        foreach ($xml as $child) {
            $type = $child->getName();

            $types = ['event', 'actor', 'production'];
            if (in_array($type, $types)) {
                $cdbItem = CultureFeed_Cdb_Default::parseItem($child);

                $data['documents'][] = new Document(
                    [
                        'type' => $type,
                        'item' => $cdbItem
                    ]
                );
            }
        }

        return $data;
    }
}
