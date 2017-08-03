<?php

namespace DB\Map;

use DB\Mailing;
use DB\MailingQuery;
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
 * This class defines the structure of the 'Mailings' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class MailingTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'DB.Map.MailingTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'Mailings';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\DB\\Mailing';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'DB.Mailing';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 14;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 14;

    /**
     * the column name for the id field
     */
    const COL_ID = 'Mailings.id';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'Mailings.name';

    /**
     * the column name for the headline field
     */
    const COL_HEADLINE = 'Mailings.headline';

    /**
     * the column name for the content field
     */
    const COL_CONTENT = 'Mailings.content';

    /**
     * the column name for the description field
     */
    const COL_DESCRIPTION = 'Mailings.description';

    /**
     * the column name for the fromEmail field
     */
    const COL_FROMEMAIL = 'Mailings.fromEmail';

    /**
     * the column name for the fromName field
     */
    const COL_FROMNAME = 'Mailings.fromName';

    /**
     * the column name for the tracking field
     */
    const COL_TRACKING = 'Mailings.tracking';

    /**
     * the column name for the isSmtp field
     */
    const COL_ISSMTP = 'Mailings.isSmtp';

    /**
     * the column name for the smtpHost field
     */
    const COL_SMTPHOST = 'Mailings.smtpHost';

    /**
     * the column name for the smtpUser field
     */
    const COL_SMTPUSER = 'Mailings.smtpUser';

    /**
     * the column name for the smtpPassword field
     */
    const COL_SMTPPASSWORD = 'Mailings.smtpPassword';

    /**
     * the column name for the smtpSecure field
     */
    const COL_SMTPSECURE = 'Mailings.smtpSecure';

    /**
     * the column name for the smtpPort field
     */
    const COL_SMTPPORT = 'Mailings.smtpPort';

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
        self::TYPE_PHPNAME       => array('Id', 'Name', 'Headline', 'Content', 'Description', 'Fromemail', 'Fromname', 'Tracking', 'Issmtp', 'Smtphost', 'Smtpuser', 'Smtppassword', 'Smtpsecure', 'Smtpport', ),
        self::TYPE_CAMELNAME     => array('id', 'name', 'headline', 'content', 'description', 'fromemail', 'fromname', 'tracking', 'issmtp', 'smtphost', 'smtpuser', 'smtppassword', 'smtpsecure', 'smtpport', ),
        self::TYPE_COLNAME       => array(MailingTableMap::COL_ID, MailingTableMap::COL_NAME, MailingTableMap::COL_HEADLINE, MailingTableMap::COL_CONTENT, MailingTableMap::COL_DESCRIPTION, MailingTableMap::COL_FROMEMAIL, MailingTableMap::COL_FROMNAME, MailingTableMap::COL_TRACKING, MailingTableMap::COL_ISSMTP, MailingTableMap::COL_SMTPHOST, MailingTableMap::COL_SMTPUSER, MailingTableMap::COL_SMTPPASSWORD, MailingTableMap::COL_SMTPSECURE, MailingTableMap::COL_SMTPPORT, ),
        self::TYPE_FIELDNAME     => array('id', 'name', 'headline', 'content', 'description', 'fromEmail', 'fromName', 'tracking', 'isSmtp', 'smtpHost', 'smtpUser', 'smtpPassword', 'smtpSecure', 'smtpPort', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Name' => 1, 'Headline' => 2, 'Content' => 3, 'Description' => 4, 'Fromemail' => 5, 'Fromname' => 6, 'Tracking' => 7, 'Issmtp' => 8, 'Smtphost' => 9, 'Smtpuser' => 10, 'Smtppassword' => 11, 'Smtpsecure' => 12, 'Smtpport' => 13, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'name' => 1, 'headline' => 2, 'content' => 3, 'description' => 4, 'fromemail' => 5, 'fromname' => 6, 'tracking' => 7, 'issmtp' => 8, 'smtphost' => 9, 'smtpuser' => 10, 'smtppassword' => 11, 'smtpsecure' => 12, 'smtpport' => 13, ),
        self::TYPE_COLNAME       => array(MailingTableMap::COL_ID => 0, MailingTableMap::COL_NAME => 1, MailingTableMap::COL_HEADLINE => 2, MailingTableMap::COL_CONTENT => 3, MailingTableMap::COL_DESCRIPTION => 4, MailingTableMap::COL_FROMEMAIL => 5, MailingTableMap::COL_FROMNAME => 6, MailingTableMap::COL_TRACKING => 7, MailingTableMap::COL_ISSMTP => 8, MailingTableMap::COL_SMTPHOST => 9, MailingTableMap::COL_SMTPUSER => 10, MailingTableMap::COL_SMTPPASSWORD => 11, MailingTableMap::COL_SMTPSECURE => 12, MailingTableMap::COL_SMTPPORT => 13, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'name' => 1, 'headline' => 2, 'content' => 3, 'description' => 4, 'fromEmail' => 5, 'fromName' => 6, 'tracking' => 7, 'isSmtp' => 8, 'smtpHost' => 9, 'smtpUser' => 10, 'smtpPassword' => 11, 'smtpSecure' => 12, 'smtpPort' => 13, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
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
        $this->setName('Mailings');
        $this->setPhpName('Mailing');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\DB\\Mailing');
        $this->setPackage('DB');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 100, null);
        $this->addColumn('headline', 'Headline', 'VARCHAR', true, 100, null);
        $this->addColumn('content', 'Content', 'VARCHAR', true, 5000, null);
        $this->addColumn('description', 'Description', 'VARCHAR', false, 1000, null);
        $this->addColumn('fromEmail', 'Fromemail', 'VARCHAR', false, 100, null);
        $this->addColumn('fromName', 'Fromname', 'VARCHAR', false, 100, null);
        $this->addColumn('tracking', 'Tracking', 'TINYINT', false, 1, null);
        $this->addColumn('isSmtp', 'Issmtp', 'BOOLEAN', false, 1, null);
        $this->addColumn('smtpHost', 'Smtphost', 'VARCHAR', false, 100, null);
        $this->addColumn('smtpUser', 'Smtpuser', 'VARCHAR', false, 100, null);
        $this->addColumn('smtpPassword', 'Smtppassword', 'VARCHAR', false, 100, null);
        $this->addColumn('smtpSecure', 'Smtpsecure', 'VARCHAR', false, 100, null);
        $this->addColumn('smtpPort', 'Smtpport', 'VARCHAR', false, 100, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('WebVisit', '\\DB\\WebVisit', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':mailing_id',
    1 => ':id',
  ),
), null, null, 'WebVisits', false);
        $this->addRelation('WebConversion', '\\DB\\WebConversion', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':mailing_id',
    1 => ':id',
  ),
), null, null, 'WebConversions', false);
        $this->addRelation('VictimMailings', '\\DB\\VictimMailings', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':mailing_id',
    1 => ':id',
  ),
), null, null, 'VictimMailingss', false);
        $this->addRelation('UserMailings', '\\DB\\UserMailings', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':mailing_id',
    1 => ':id',
  ),
), null, null, 'UserMailingss', false);
        $this->addRelation('GroupMailings', '\\DB\\GroupMailings', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':mailing_id',
    1 => ':id',
  ),
), null, null, 'GroupMailingss', false);
        $this->addRelation('User', '\\DB\\User', RelationMap::MANY_TO_MANY, array(), null, null, 'Users');
        $this->addRelation('Group', '\\DB\\Group', RelationMap::MANY_TO_MANY, array(), null, null, 'Groups');
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
        return $withPrefix ? MailingTableMap::CLASS_DEFAULT : MailingTableMap::OM_CLASS;
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
     * @return array           (Mailing object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = MailingTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = MailingTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + MailingTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = MailingTableMap::OM_CLASS;
            /** @var Mailing $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            MailingTableMap::addInstanceToPool($obj, $key);
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
            $key = MailingTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = MailingTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Mailing $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                MailingTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(MailingTableMap::COL_ID);
            $criteria->addSelectColumn(MailingTableMap::COL_NAME);
            $criteria->addSelectColumn(MailingTableMap::COL_HEADLINE);
            $criteria->addSelectColumn(MailingTableMap::COL_CONTENT);
            $criteria->addSelectColumn(MailingTableMap::COL_DESCRIPTION);
            $criteria->addSelectColumn(MailingTableMap::COL_FROMEMAIL);
            $criteria->addSelectColumn(MailingTableMap::COL_FROMNAME);
            $criteria->addSelectColumn(MailingTableMap::COL_TRACKING);
            $criteria->addSelectColumn(MailingTableMap::COL_ISSMTP);
            $criteria->addSelectColumn(MailingTableMap::COL_SMTPHOST);
            $criteria->addSelectColumn(MailingTableMap::COL_SMTPUSER);
            $criteria->addSelectColumn(MailingTableMap::COL_SMTPPASSWORD);
            $criteria->addSelectColumn(MailingTableMap::COL_SMTPSECURE);
            $criteria->addSelectColumn(MailingTableMap::COL_SMTPPORT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.headline');
            $criteria->addSelectColumn($alias . '.content');
            $criteria->addSelectColumn($alias . '.description');
            $criteria->addSelectColumn($alias . '.fromEmail');
            $criteria->addSelectColumn($alias . '.fromName');
            $criteria->addSelectColumn($alias . '.tracking');
            $criteria->addSelectColumn($alias . '.isSmtp');
            $criteria->addSelectColumn($alias . '.smtpHost');
            $criteria->addSelectColumn($alias . '.smtpUser');
            $criteria->addSelectColumn($alias . '.smtpPassword');
            $criteria->addSelectColumn($alias . '.smtpSecure');
            $criteria->addSelectColumn($alias . '.smtpPort');
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
        return Propel::getServiceContainer()->getDatabaseMap(MailingTableMap::DATABASE_NAME)->getTable(MailingTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(MailingTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(MailingTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new MailingTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Mailing or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Mailing object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(MailingTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \DB\Mailing) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(MailingTableMap::DATABASE_NAME);
            $criteria->add(MailingTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = MailingQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            MailingTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                MailingTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the Mailings table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return MailingQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Mailing or Criteria object.
     *
     * @param mixed               $criteria Criteria or Mailing object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MailingTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Mailing object
        }

        if ($criteria->containsKey(MailingTableMap::COL_ID) && $criteria->keyContainsValue(MailingTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.MailingTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = MailingQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // MailingTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
MailingTableMap::buildTableMap();
