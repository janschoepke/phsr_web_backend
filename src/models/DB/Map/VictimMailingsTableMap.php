<?php

namespace DB\Map;

use DB\VictimMailings;
use DB\VictimMailingsQuery;
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
 * This class defines the structure of the 'Victim_Mailings' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class VictimMailingsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'DB.Map.VictimMailingsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'Victim_Mailings';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\DB\\VictimMailings';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'DB.VictimMailings';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the victim_id field
     */
    const COL_VICTIM_ID = 'Victim_Mailings.victim_id';

    /**
     * the column name for the mailing_id field
     */
    const COL_MAILING_ID = 'Victim_Mailings.mailing_id';

    /**
     * the column name for the timestamp field
     */
    const COL_TIMESTAMP = 'Victim_Mailings.timestamp';

    /**
     * the column name for the opened field
     */
    const COL_OPENED = 'Victim_Mailings.opened';

    /**
     * the column name for the clicked field
     */
    const COL_CLICKED = 'Victim_Mailings.clicked';

    /**
     * the column name for the customParam field
     */
    const COL_CUSTOMPARAM = 'Victim_Mailings.customParam';

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
        self::TYPE_PHPNAME       => array('VictimId', 'MailingId', 'Timestamp', 'Opened', 'Clicked', 'Customparam', ),
        self::TYPE_CAMELNAME     => array('victimId', 'mailingId', 'timestamp', 'opened', 'clicked', 'customparam', ),
        self::TYPE_COLNAME       => array(VictimMailingsTableMap::COL_VICTIM_ID, VictimMailingsTableMap::COL_MAILING_ID, VictimMailingsTableMap::COL_TIMESTAMP, VictimMailingsTableMap::COL_OPENED, VictimMailingsTableMap::COL_CLICKED, VictimMailingsTableMap::COL_CUSTOMPARAM, ),
        self::TYPE_FIELDNAME     => array('victim_id', 'mailing_id', 'timestamp', 'opened', 'clicked', 'customParam', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('VictimId' => 0, 'MailingId' => 1, 'Timestamp' => 2, 'Opened' => 3, 'Clicked' => 4, 'Customparam' => 5, ),
        self::TYPE_CAMELNAME     => array('victimId' => 0, 'mailingId' => 1, 'timestamp' => 2, 'opened' => 3, 'clicked' => 4, 'customparam' => 5, ),
        self::TYPE_COLNAME       => array(VictimMailingsTableMap::COL_VICTIM_ID => 0, VictimMailingsTableMap::COL_MAILING_ID => 1, VictimMailingsTableMap::COL_TIMESTAMP => 2, VictimMailingsTableMap::COL_OPENED => 3, VictimMailingsTableMap::COL_CLICKED => 4, VictimMailingsTableMap::COL_CUSTOMPARAM => 5, ),
        self::TYPE_FIELDNAME     => array('victim_id' => 0, 'mailing_id' => 1, 'timestamp' => 2, 'opened' => 3, 'clicked' => 4, 'customParam' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
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
        $this->setName('Victim_Mailings');
        $this->setPhpName('VictimMailings');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\DB\\VictimMailings');
        $this->setPackage('DB');
        $this->setUseIdGenerator(false);
        $this->setIsCrossRef(true);
        // columns
        $this->addForeignPrimaryKey('victim_id', 'VictimId', 'INTEGER' , 'Victims', 'id', true, null, null);
        $this->addForeignPrimaryKey('mailing_id', 'MailingId', 'INTEGER' , 'Mailings', 'id', true, null, null);
        $this->addColumn('timestamp', 'Timestamp', 'TIMESTAMP', false, null, null);
        $this->addColumn('opened', 'Opened', 'TINYINT', false, null, null);
        $this->addColumn('clicked', 'Clicked', 'TINYINT', false, null, null);
        $this->addColumn('customParam', 'Customparam', 'VARCHAR', true, 10, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Victim', '\\DB\\Victim', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':victim_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Mailing', '\\DB\\Mailing', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':mailing_id',
    1 => ':id',
  ),
), null, null, null, false);
    } // buildRelations()

    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database. In some cases you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by find*()
     * and findPk*() calls.
     *
     * @param \DB\VictimMailings $obj A \DB\VictimMailings object.
     * @param string $key             (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (null === $key) {
                $key = serialize([(null === $obj->getVictimId() || is_scalar($obj->getVictimId()) || is_callable([$obj->getVictimId(), '__toString']) ? (string) $obj->getVictimId() : $obj->getVictimId()), (null === $obj->getMailingId() || is_scalar($obj->getMailingId()) || is_callable([$obj->getMailingId(), '__toString']) ? (string) $obj->getMailingId() : $obj->getMailingId())]);
            } // if key === null
            self::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param mixed $value A \DB\VictimMailings object or a primary key value.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof \DB\VictimMailings) {
                $key = serialize([(null === $value->getVictimId() || is_scalar($value->getVictimId()) || is_callable([$value->getVictimId(), '__toString']) ? (string) $value->getVictimId() : $value->getVictimId()), (null === $value->getMailingId() || is_scalar($value->getMailingId()) || is_callable([$value->getMailingId(), '__toString']) ? (string) $value->getMailingId() : $value->getMailingId())]);

            } elseif (is_array($value) && count($value) === 2) {
                // assume we've been passed a primary key";
                $key = serialize([(null === $value[0] || is_scalar($value[0]) || is_callable([$value[0], '__toString']) ? (string) $value[0] : $value[0]), (null === $value[1] || is_scalar($value[1]) || is_callable([$value[1], '__toString']) ? (string) $value[1] : $value[1])]);
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \DB\VictimMailings object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
                throw $e;
            }

            unset(self::$instances[$key]);
        }
    }

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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('VictimId', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('MailingId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize([(null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('VictimId', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('VictimId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('VictimId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('VictimId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('VictimId', TableMap::TYPE_PHPNAME, $indexType)]), (null === $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('MailingId', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('MailingId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('MailingId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('MailingId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('MailingId', TableMap::TYPE_PHPNAME, $indexType)])]);
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
            $pks = [];

        $pks[] = (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('VictimId', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 1 + $offset
                : self::translateFieldName('MailingId', TableMap::TYPE_PHPNAME, $indexType)
        ];

        return $pks;
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
        return $withPrefix ? VictimMailingsTableMap::CLASS_DEFAULT : VictimMailingsTableMap::OM_CLASS;
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
     * @return array           (VictimMailings object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = VictimMailingsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = VictimMailingsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + VictimMailingsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = VictimMailingsTableMap::OM_CLASS;
            /** @var VictimMailings $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            VictimMailingsTableMap::addInstanceToPool($obj, $key);
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
            $key = VictimMailingsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = VictimMailingsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var VictimMailings $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                VictimMailingsTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(VictimMailingsTableMap::COL_VICTIM_ID);
            $criteria->addSelectColumn(VictimMailingsTableMap::COL_MAILING_ID);
            $criteria->addSelectColumn(VictimMailingsTableMap::COL_TIMESTAMP);
            $criteria->addSelectColumn(VictimMailingsTableMap::COL_OPENED);
            $criteria->addSelectColumn(VictimMailingsTableMap::COL_CLICKED);
            $criteria->addSelectColumn(VictimMailingsTableMap::COL_CUSTOMPARAM);
        } else {
            $criteria->addSelectColumn($alias . '.victim_id');
            $criteria->addSelectColumn($alias . '.mailing_id');
            $criteria->addSelectColumn($alias . '.timestamp');
            $criteria->addSelectColumn($alias . '.opened');
            $criteria->addSelectColumn($alias . '.clicked');
            $criteria->addSelectColumn($alias . '.customParam');
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
        return Propel::getServiceContainer()->getDatabaseMap(VictimMailingsTableMap::DATABASE_NAME)->getTable(VictimMailingsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(VictimMailingsTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(VictimMailingsTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new VictimMailingsTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a VictimMailings or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or VictimMailings object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(VictimMailingsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \DB\VictimMailings) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(VictimMailingsTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = array($values);
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(VictimMailingsTableMap::COL_VICTIM_ID, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(VictimMailingsTableMap::COL_MAILING_ID, $value[1]));
                $criteria->addOr($criterion);
            }
        }

        $query = VictimMailingsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            VictimMailingsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                VictimMailingsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the Victim_Mailings table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return VictimMailingsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a VictimMailings or Criteria object.
     *
     * @param mixed               $criteria Criteria or VictimMailings object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(VictimMailingsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from VictimMailings object
        }


        // Set the correct dbName
        $query = VictimMailingsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // VictimMailingsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
VictimMailingsTableMap::buildTableMap();
