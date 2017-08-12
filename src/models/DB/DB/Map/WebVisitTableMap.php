<?php

namespace DB\Map;

use DB\WebVisit;
use DB\WebVisitQuery;
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
 * This class defines the structure of the 'WebVisits' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class WebVisitTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'DB.Map.WebVisitTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'WebVisits';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\DB\\WebVisit';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'DB.WebVisit';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 11;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 11;

    /**
     * the column name for the id field
     */
    const COL_ID = 'WebVisits.id';

    /**
     * the column name for the mailing_id field
     */
    const COL_MAILING_ID = 'WebVisits.mailing_id';

    /**
     * the column name for the group_id field
     */
    const COL_GROUP_ID = 'WebVisits.group_id';

    /**
     * the column name for the os field
     */
    const COL_OS = 'WebVisits.os';

    /**
     * the column name for the timestamp field
     */
    const COL_TIMESTAMP = 'WebVisits.timestamp';

    /**
     * the column name for the url field
     */
    const COL_URL = 'WebVisits.url';

    /**
     * the column name for the victim_id field
     */
    const COL_VICTIM_ID = 'WebVisits.victim_id';

    /**
     * the column name for the unknown_id field
     */
    const COL_UNKNOWN_ID = 'WebVisits.unknown_id';

    /**
     * the column name for the browser field
     */
    const COL_BROWSER = 'WebVisits.browser';

    /**
     * the column name for the ip field
     */
    const COL_IP = 'WebVisits.ip';

    /**
     * the column name for the unique_id field
     */
    const COL_UNIQUE_ID = 'WebVisits.unique_id';

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
        self::TYPE_PHPNAME       => array('Id', 'MailingId', 'GroupId', 'Os', 'Timestamp', 'Url', 'VictimId', 'UnknownId', 'Browser', 'Ip', 'UniqueId', ),
        self::TYPE_CAMELNAME     => array('id', 'mailingId', 'groupId', 'os', 'timestamp', 'url', 'victimId', 'unknownId', 'browser', 'ip', 'uniqueId', ),
        self::TYPE_COLNAME       => array(WebVisitTableMap::COL_ID, WebVisitTableMap::COL_MAILING_ID, WebVisitTableMap::COL_GROUP_ID, WebVisitTableMap::COL_OS, WebVisitTableMap::COL_TIMESTAMP, WebVisitTableMap::COL_URL, WebVisitTableMap::COL_VICTIM_ID, WebVisitTableMap::COL_UNKNOWN_ID, WebVisitTableMap::COL_BROWSER, WebVisitTableMap::COL_IP, WebVisitTableMap::COL_UNIQUE_ID, ),
        self::TYPE_FIELDNAME     => array('id', 'mailing_id', 'group_id', 'os', 'timestamp', 'url', 'victim_id', 'unknown_id', 'browser', 'ip', 'unique_id', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'MailingId' => 1, 'GroupId' => 2, 'Os' => 3, 'Timestamp' => 4, 'Url' => 5, 'VictimId' => 6, 'UnknownId' => 7, 'Browser' => 8, 'Ip' => 9, 'UniqueId' => 10, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'mailingId' => 1, 'groupId' => 2, 'os' => 3, 'timestamp' => 4, 'url' => 5, 'victimId' => 6, 'unknownId' => 7, 'browser' => 8, 'ip' => 9, 'uniqueId' => 10, ),
        self::TYPE_COLNAME       => array(WebVisitTableMap::COL_ID => 0, WebVisitTableMap::COL_MAILING_ID => 1, WebVisitTableMap::COL_GROUP_ID => 2, WebVisitTableMap::COL_OS => 3, WebVisitTableMap::COL_TIMESTAMP => 4, WebVisitTableMap::COL_URL => 5, WebVisitTableMap::COL_VICTIM_ID => 6, WebVisitTableMap::COL_UNKNOWN_ID => 7, WebVisitTableMap::COL_BROWSER => 8, WebVisitTableMap::COL_IP => 9, WebVisitTableMap::COL_UNIQUE_ID => 10, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'mailing_id' => 1, 'group_id' => 2, 'os' => 3, 'timestamp' => 4, 'url' => 5, 'victim_id' => 6, 'unknown_id' => 7, 'browser' => 8, 'ip' => 9, 'unique_id' => 10, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
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
        $this->setName('WebVisits');
        $this->setPhpName('WebVisit');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\DB\\WebVisit');
        $this->setPackage('DB');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('mailing_id', 'MailingId', 'INTEGER', 'Mailings', 'id', true, null, null);
        $this->addForeignKey('group_id', 'GroupId', 'INTEGER', 'Groups', 'id', false, null, null);
        $this->addColumn('os', 'Os', 'VARCHAR', false, 100, null);
        $this->addColumn('timestamp', 'Timestamp', 'TIMESTAMP', false, null, null);
        $this->addColumn('url', 'Url', 'VARCHAR', false, 100, null);
        $this->addForeignKey('victim_id', 'VictimId', 'INTEGER', 'Victims', 'id', false, null, null);
        $this->addColumn('unknown_id', 'UnknownId', 'VARCHAR', false, 20, null);
        $this->addColumn('browser', 'Browser', 'VARCHAR', false, 100, null);
        $this->addColumn('ip', 'Ip', 'VARCHAR', false, 100, null);
        $this->addColumn('unique_id', 'UniqueId', 'VARCHAR', false, 255, null);
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
        $this->addRelation('Group', '\\DB\\Group', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':group_id',
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
        return $withPrefix ? WebVisitTableMap::CLASS_DEFAULT : WebVisitTableMap::OM_CLASS;
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
     * @return array           (WebVisit object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = WebVisitTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = WebVisitTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + WebVisitTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = WebVisitTableMap::OM_CLASS;
            /** @var WebVisit $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            WebVisitTableMap::addInstanceToPool($obj, $key);
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
            $key = WebVisitTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = WebVisitTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var WebVisit $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                WebVisitTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(WebVisitTableMap::COL_ID);
            $criteria->addSelectColumn(WebVisitTableMap::COL_MAILING_ID);
            $criteria->addSelectColumn(WebVisitTableMap::COL_GROUP_ID);
            $criteria->addSelectColumn(WebVisitTableMap::COL_OS);
            $criteria->addSelectColumn(WebVisitTableMap::COL_TIMESTAMP);
            $criteria->addSelectColumn(WebVisitTableMap::COL_URL);
            $criteria->addSelectColumn(WebVisitTableMap::COL_VICTIM_ID);
            $criteria->addSelectColumn(WebVisitTableMap::COL_UNKNOWN_ID);
            $criteria->addSelectColumn(WebVisitTableMap::COL_BROWSER);
            $criteria->addSelectColumn(WebVisitTableMap::COL_IP);
            $criteria->addSelectColumn(WebVisitTableMap::COL_UNIQUE_ID);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.mailing_id');
            $criteria->addSelectColumn($alias . '.group_id');
            $criteria->addSelectColumn($alias . '.os');
            $criteria->addSelectColumn($alias . '.timestamp');
            $criteria->addSelectColumn($alias . '.url');
            $criteria->addSelectColumn($alias . '.victim_id');
            $criteria->addSelectColumn($alias . '.unknown_id');
            $criteria->addSelectColumn($alias . '.browser');
            $criteria->addSelectColumn($alias . '.ip');
            $criteria->addSelectColumn($alias . '.unique_id');
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
        return Propel::getServiceContainer()->getDatabaseMap(WebVisitTableMap::DATABASE_NAME)->getTable(WebVisitTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(WebVisitTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(WebVisitTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new WebVisitTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a WebVisit or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or WebVisit object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(WebVisitTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \DB\WebVisit) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(WebVisitTableMap::DATABASE_NAME);
            $criteria->add(WebVisitTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = WebVisitQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            WebVisitTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                WebVisitTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the WebVisits table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return WebVisitQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a WebVisit or Criteria object.
     *
     * @param mixed               $criteria Criteria or WebVisit object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(WebVisitTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from WebVisit object
        }

        if ($criteria->containsKey(WebVisitTableMap::COL_ID) && $criteria->keyContainsValue(WebVisitTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.WebVisitTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = WebVisitQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // WebVisitTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
WebVisitTableMap::buildTableMap();
