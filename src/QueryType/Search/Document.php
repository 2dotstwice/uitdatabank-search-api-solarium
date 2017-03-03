<?php

namespace TwoDotsTwice\UiTDBSearchSolarium\QueryType\Search;

use CultureFeed_Cdb_Item_Actor;
use CultureFeed_Cdb_Item_Event;
use CultureFeed_Cdb_Item_Production;
use Solarium\QueryType\Select\Result\Document as BaseDocument;

/**
 * @property string $type
 * @property CultureFeed_Cdb_Item_Event|CultureFeed_Cdb_Item_Actor|CultureFeed_Cdb_Item_Production $item
 */
class Document extends BaseDocument
{

}
