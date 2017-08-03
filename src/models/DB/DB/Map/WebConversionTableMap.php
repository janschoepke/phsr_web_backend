<?php

namespace DB\Map;

use DB\WebConversion;
use DB\WebConversionQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'WebConversions' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class WebConversionTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'DB.Map.WebConversionTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'WebConversions';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\DB\\WebConversion';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'DB.WebConversion';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 7;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the id field
     */
    const COL_ID = 'WebConversions.id';

    /**
     * the column name for the mailing_id field
     */
    const COL_MAILING_ID = 'WebConversions.mailing_id';

    /**
     * the column name for the timestamp field
     */
    const COL_TIMESTAMP = 'WebConversions.timestamp';

    /**
     * the column name for the victim_id field
     */
    const COL_VICTIM_ID = 'WebConversions.victim_id';

    /**
     * the column name for the unknown_id field
     */
    const COL_UNKNOWN_ID = 'WebConversions.unknown_id';

    /**
     * the column name for the conversion_name field
     */
    const COL_CONVERSION_NAME = 'WebConversions.conversion_name';

    /**
     * the column name for the form_data field
     */
    const COL_FORM_DATA = 'WebConversions.form_data';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'MailingId', 'Timestamp', 'VictimId', 'UnknownId', 'ConversionName', 'FormData', ),
        self::TYPE_CAMELNAME     => array('id', 'mailingId', 'timestamp', 'victimId', 'unknownId', 'conversionName', 'formData', ),
        self::TYPE_COLNAME       => array(WebConversionTableMap::COL_ID, WebConversionTableMap::COL_MAILING_ID, WebConversionTableMap::COL_TIMESTAMP, WebConversionTableMap::COL_VICTIM_ID, WebConversionTableMap::COL_UNKNOWN_ID, WebConversionTableMap::COL_CONVERSION_NAME, WebConversionTableMap::COL_FORM_DATA, ),
        self::TYPE_FIELDNAME     => array('id', 'mailing_id', 'timestamp', 'victim_id', 'unknown_id', 'conversion_name', 'form_data', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'MailingId' => 1, 'Timestamp' => 2, 'VictimId' => 3, 'UnknownId' => 4, 'ConversionName' => 5, 'FormData' => 6, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'mailingId' => 1, 'timestamp' => 2, 'victimId' => 3, 'unknownId' => 4, 'conversionName' => 5, 'formData' => 6, ),
        self::TYPE_COLNAME       => array(WebConversionTableMap::COL_ID => 0, WebConversionTableMap::COL_MAILING_ID => 1, WebConversionTableMap::COL_TIMESTAMP => 2, WebConversionTableMap::COL_VICTIM_ID => 3, WebConversionTableMap::COL_UNKNOWN_ID => 4, WebConversionTableMap::COL_CONVERSION_NAME => 5, WebConversionTableMap::COL_FORM_DATA => 6, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'mailing_id' => 1, 'timestamp' => 2, 'victim_id' => 3, 'unknown_id' => 4, 'conversion_name' => 5, 'form_data' => 6, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('WebConversions');
        $this->setPhpName('WebConversion');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\DB\\WebConversion');
        $this->setPackage('DB');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('mailing_id', 'MailingId', 'INTEGER', 'Mailings', 'id', true, null, null);
        $this->addColumn('timestamp', 'Timestamp', 'TIMESTAMP', false, null, null);
        $this->addForeignKey('victim_id', 'VictimId', 'INTEGER', 'Victims', 'id', false, null, null);
        $this->addColumn('unknown_id', 'UnknownId', 'VARCHAR', false, 10, null);
        $this->addColumn('conversion_name', 'ConversionName', 'VARCHAR', false, 100, null);
        $this->addColumn('form_data', 'FormData', 'VARCHAR', false, 1000, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Mailing', '\\DB\\Mailing', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':mailing_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Victim', '\\DB\\Victim', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':victim_id',
    1 => ':id',
  ),
), null, null, null, false);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? WebConversionTableMap::CLASS_DEFAULT : WebConversionTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (WebConversion object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = WebConversionTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = WebConversionTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + WebConversionTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = WebConversionTableMap::OM_CLASS;
            /** @var WebConversion $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            WebConversionTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = WebConversionTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = WebConversionTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var WebConversion $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                WebConversionTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(WebConversionTableMap::COL_ID);
            $criteria->addSelectColumn(WebConversionTableMap::COL_MAILING_ID);
            $criteria->addSelectColumn(WebConversionTableMap::COL_TIMESTAMP);
            $criteria->addSelectColumn(WebConversionTableMap::COL_VICTIM_ID);
            $criteria->addSelectColumn(WebConversionTableMap::COL_UNKNOWN_ID);
            $criteria->addSelectColumn(WebConversionTableMap::COL_CONVERSION_NAME);
            $criteria->addSelectColumn(WebConversionTableMap::COL_FORM_DATA);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.mailing_id');
            $criteria->addSelectColumn($alias . '.timestamp');
            $criteria->addSelectColumn($alias . '.victim_id');
            $criteria->addSelectColumn($alias . '.unknown_id');
            $criteria->addSelectColumn($alias . '.conversion_name');
            $criteria->addSelectColumn($alias . '.form_data');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(WebConversionTableMap::DATABASE_NAME)->getTable(WebConversionTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(WebConversionTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(WebConversionTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new WebConversionTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a WebConversion or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or WebConversion object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(WebConversionTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \DB\WebConversion) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(WebConversionTableMap::DATABASE_NAME);
            $criteria->add(WebConversionTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = WebConversionQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            WebConversionTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                WebConversionTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the WebConversions table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return WebConversionQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a WebConversion or Criteria object.
     *
     * @param mixed               $criteria Criteria or WebConversion object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(WebConversionTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from WebConversion object
        }

        if ($criteria->containsKey(WebConversionTableMap::COL_ID) && $criteria->keyContainsValue(WebConversionTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.WebConversionTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = WebConversionQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // WebConversionTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
WebConversionTableMap::buildTableMap();
