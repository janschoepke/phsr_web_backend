<?php

namespace DB\Map;

use DB\CampaignResult;
use DB\CampaignResultQuery;
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
 * This class defines the structure of the 'CampaignResults' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class CampaignResultTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'DB.Map.CampaignResultTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'CampaignResults';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\DB\\CampaignResult';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'DB.CampaignResult';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the id field
     */
    const COL_ID = 'CampaignResults.id';

    /**
     * the column name for the timestamp field
     */
    const COL_TIMESTAMP = 'CampaignResults.timestamp';

    /**
     * the column name for the computer_name field
     */
    const COL_COMPUTER_NAME = 'CampaignResults.computer_name';

    /**
     * the column name for the user_name field
     */
    const COL_USER_NAME = 'CampaignResults.user_name';

    /**
     * the column name for the internal_ip field
     */
    const COL_INTERNAL_IP = 'CampaignResults.internal_ip';

    /**
     * the column name for the external_ip field
     */
    const COL_EXTERNAL_IP = 'CampaignResults.external_ip';

    /**
     * the column name for the os_version field
     */
    const COL_OS_VERSION = 'CampaignResults.os_version';

    /**
     * the column name for the campaign_id field
     */
    const COL_CAMPAIGN_ID = 'CampaignResults.campaign_id';

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
        self::TYPE_PHPNAME       => array('Id', 'Timestamp', 'ComputerName', 'UserName', 'InternalIp', 'ExternalIp', 'OsVersion', 'CampaignId', ),
        self::TYPE_CAMELNAME     => array('id', 'timestamp', 'computerName', 'userName', 'internalIp', 'externalIp', 'osVersion', 'campaignId', ),
        self::TYPE_COLNAME       => array(CampaignResultTableMap::COL_ID, CampaignResultTableMap::COL_TIMESTAMP, CampaignResultTableMap::COL_COMPUTER_NAME, CampaignResultTableMap::COL_USER_NAME, CampaignResultTableMap::COL_INTERNAL_IP, CampaignResultTableMap::COL_EXTERNAL_IP, CampaignResultTableMap::COL_OS_VERSION, CampaignResultTableMap::COL_CAMPAIGN_ID, ),
        self::TYPE_FIELDNAME     => array('id', 'timestamp', 'computer_name', 'user_name', 'internal_ip', 'external_ip', 'os_version', 'campaign_id', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Timestamp' => 1, 'ComputerName' => 2, 'UserName' => 3, 'InternalIp' => 4, 'ExternalIp' => 5, 'OsVersion' => 6, 'CampaignId' => 7, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'timestamp' => 1, 'computerName' => 2, 'userName' => 3, 'internalIp' => 4, 'externalIp' => 5, 'osVersion' => 6, 'campaignId' => 7, ),
        self::TYPE_COLNAME       => array(CampaignResultTableMap::COL_ID => 0, CampaignResultTableMap::COL_TIMESTAMP => 1, CampaignResultTableMap::COL_COMPUTER_NAME => 2, CampaignResultTableMap::COL_USER_NAME => 3, CampaignResultTableMap::COL_INTERNAL_IP => 4, CampaignResultTableMap::COL_EXTERNAL_IP => 5, CampaignResultTableMap::COL_OS_VERSION => 6, CampaignResultTableMap::COL_CAMPAIGN_ID => 7, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'timestamp' => 1, 'computer_name' => 2, 'user_name' => 3, 'internal_ip' => 4, 'external_ip' => 5, 'os_version' => 6, 'campaign_id' => 7, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
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
        $this->setName('CampaignResults');
        $this->setPhpName('CampaignResult');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\DB\\CampaignResult');
        $this->setPackage('DB');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('timestamp', 'Timestamp', 'TIMESTAMP', false, null, null);
        $this->addColumn('computer_name', 'ComputerName', 'VARCHAR', false, 100, null);
        $this->addColumn('user_name', 'UserName', 'VARCHAR', false, 100, null);
        $this->addColumn('internal_ip', 'InternalIp', 'VARCHAR', false, 100, null);
        $this->addColumn('external_ip', 'ExternalIp', 'VARCHAR', false, 100, null);
        $this->addColumn('os_version', 'OsVersion', 'VARCHAR', false, 100, null);
        $this->addForeignKey('campaign_id', 'CampaignId', 'INTEGER', 'MalwareCampaigns', 'id', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('MalwareCampaign', '\\DB\\MalwareCampaign', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':campaign_id',
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
        return $withPrefix ? CampaignResultTableMap::CLASS_DEFAULT : CampaignResultTableMap::OM_CLASS;
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
     * @return array           (CampaignResult object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = CampaignResultTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = CampaignResultTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + CampaignResultTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = CampaignResultTableMap::OM_CLASS;
            /** @var CampaignResult $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            CampaignResultTableMap::addInstanceToPool($obj, $key);
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
            $key = CampaignResultTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = CampaignResultTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var CampaignResult $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                CampaignResultTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(CampaignResultTableMap::COL_ID);
            $criteria->addSelectColumn(CampaignResultTableMap::COL_TIMESTAMP);
            $criteria->addSelectColumn(CampaignResultTableMap::COL_COMPUTER_NAME);
            $criteria->addSelectColumn(CampaignResultTableMap::COL_USER_NAME);
            $criteria->addSelectColumn(CampaignResultTableMap::COL_INTERNAL_IP);
            $criteria->addSelectColumn(CampaignResultTableMap::COL_EXTERNAL_IP);
            $criteria->addSelectColumn(CampaignResultTableMap::COL_OS_VERSION);
            $criteria->addSelectColumn(CampaignResultTableMap::COL_CAMPAIGN_ID);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.timestamp');
            $criteria->addSelectColumn($alias . '.computer_name');
            $criteria->addSelectColumn($alias . '.user_name');
            $criteria->addSelectColumn($alias . '.internal_ip');
            $criteria->addSelectColumn($alias . '.external_ip');
            $criteria->addSelectColumn($alias . '.os_version');
            $criteria->addSelectColumn($alias . '.campaign_id');
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
        return Propel::getServiceContainer()->getDatabaseMap(CampaignResultTableMap::DATABASE_NAME)->getTable(CampaignResultTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(CampaignResultTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(CampaignResultTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new CampaignResultTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a CampaignResult or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or CampaignResult object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(CampaignResultTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \DB\CampaignResult) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(CampaignResultTableMap::DATABASE_NAME);
            $criteria->add(CampaignResultTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = CampaignResultQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            CampaignResultTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                CampaignResultTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the CampaignResults table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return CampaignResultQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a CampaignResult or Criteria object.
     *
     * @param mixed               $criteria Criteria or CampaignResult object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CampaignResultTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from CampaignResult object
        }

        if ($criteria->containsKey(CampaignResultTableMap::COL_ID) && $criteria->keyContainsValue(CampaignResultTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.CampaignResultTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = CampaignResultQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // CampaignResultTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
CampaignResultTableMap::buildTableMap();
