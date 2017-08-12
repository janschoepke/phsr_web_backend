<?php

namespace DB\Base;

use \Exception;
use \PDO;
use DB\Group as ChildGroup;
use DB\GroupMailings as ChildGroupMailings;
use DB\GroupMailingsQuery as ChildGroupMailingsQuery;
use DB\GroupQuery as ChildGroupQuery;
use DB\GroupVictims as ChildGroupVictims;
use DB\GroupVictimsQuery as ChildGroupVictimsQuery;
use DB\Mailing as ChildMailing;
use DB\MailingQuery as ChildMailingQuery;
use DB\User as ChildUser;
use DB\UserGroups as ChildUserGroups;
use DB\UserGroupsQuery as ChildUserGroupsQuery;
use DB\UserQuery as ChildUserQuery;
use DB\Victim as ChildVictim;
use DB\VictimMailings as ChildVictimMailings;
use DB\VictimMailingsQuery as ChildVictimMailingsQuery;
use DB\VictimQuery as ChildVictimQuery;
use DB\WebConversion as ChildWebConversion;
use DB\WebConversionQuery as ChildWebConversionQuery;
use DB\WebVisit as ChildWebVisit;
use DB\WebVisitQuery as ChildWebVisitQuery;
use DB\Map\GroupMailingsTableMap;
use DB\Map\GroupTableMap;
use DB\Map\GroupVictimsTableMap;
use DB\Map\UserGroupsTableMap;
use DB\Map\VictimMailingsTableMap;
use DB\Map\WebConversionTableMap;
use DB\Map\WebVisitTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'Groups' table.
 *
 *
 *
 * @package    propel.generator.DB.Base
 */
abstract class Group implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\DB\\Map\\GroupTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the name field.
     *
     * @var        string
     */
    protected $name;

    /**
     * The value for the description field.
     *
     * @var        string
     */
    protected $description;

    /**
     * @var        ObjectCollection|ChildWebVisit[] Collection to store aggregation of ChildWebVisit objects.
     */
    protected $collWebVisits;
    protected $collWebVisitsPartial;

    /**
     * @var        ObjectCollection|ChildWebConversion[] Collection to store aggregation of ChildWebConversion objects.
     */
    protected $collWebConversions;
    protected $collWebConversionsPartial;

    /**
     * @var        ObjectCollection|ChildUserGroups[] Collection to store aggregation of ChildUserGroups objects.
     */
    protected $collUserGroupss;
    protected $collUserGroupssPartial;

    /**
     * @var        ObjectCollection|ChildGroupVictims[] Collection to store aggregation of ChildGroupVictims objects.
     */
    protected $collGroupVictimss;
    protected $collGroupVictimssPartial;

    /**
     * @var        ObjectCollection|ChildVictimMailings[] Collection to store aggregation of ChildVictimMailings objects.
     */
    protected $collVictimMailingss;
    protected $collVictimMailingssPartial;

    /**
     * @var        ObjectCollection|ChildGroupMailings[] Collection to store aggregation of ChildGroupMailings objects.
     */
    protected $collGroupMailingss;
    protected $collGroupMailingssPartial;

    /**
     * @var        ObjectCollection|ChildUser[] Cross Collection to store aggregation of ChildUser objects.
     */
    protected $collUsers;

    /**
     * @var bool
     */
    protected $collUsersPartial;

    /**
     * @var        ObjectCollection|ChildVictim[] Cross Collection to store aggregation of ChildVictim objects.
     */
    protected $collVictims;

    /**
     * @var bool
     */
    protected $collVictimsPartial;

    /**
     * @var        ObjectCollection|ChildMailing[] Cross Collection to store aggregation of ChildMailing objects.
     */
    protected $collMailings;

    /**
     * @var bool
     */
    protected $collMailingsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildUser[]
     */
    protected $usersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildVictim[]
     */
    protected $victimsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildMailing[]
     */
    protected $mailingsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildWebVisit[]
     */
    protected $webVisitsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildWebConversion[]
     */
    protected $webConversionsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildUserGroups[]
     */
    protected $userGroupssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildGroupVictims[]
     */
    protected $groupVictimssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildVictimMailings[]
     */
    protected $victimMailingssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildGroupMailings[]
     */
    protected $groupMailingssScheduledForDeletion = null;

    /**
     * Initializes internal state of DB\Base\Group object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Group</code> instance.  If
     * <code>obj</code> is an instance of <code>Group</code>, delegates to
     * <code>equals(Group)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Group The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [description] column value.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\DB\Group The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[GroupTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\DB\Group The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[GroupTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [description] column.
     *
     * @param string $v new value
     * @return $this|\DB\Group The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[GroupTableMap::COL_DESCRIPTION] = true;
        }

        return $this;
    } // setDescription()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : GroupTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : GroupTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : GroupTableMap::translateFieldName('Description', TableMap::TYPE_PHPNAME, $indexType)];
            $this->description = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 3; // 3 = GroupTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\DB\\Group'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(GroupTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildGroupQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collWebVisits = null;

            $this->collWebConversions = null;

            $this->collUserGroupss = null;

            $this->collGroupVictimss = null;

            $this->collVictimMailingss = null;

            $this->collGroupMailingss = null;

            $this->collUsers = null;
            $this->collVictims = null;
            $this->collMailings = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Group::setDeleted()
     * @see Group::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(GroupTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildGroupQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(GroupTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                GroupTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->usersScheduledForDeletion !== null) {
                if (!$this->usersScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->usersScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \DB\UserGroupsQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->usersScheduledForDeletion = null;
                }

            }

            if ($this->collUsers) {
                foreach ($this->collUsers as $user) {
                    if (!$user->isDeleted() && ($user->isNew() || $user->isModified())) {
                        $user->save($con);
                    }
                }
            }


            if ($this->victimsScheduledForDeletion !== null) {
                if (!$this->victimsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->victimsScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \DB\GroupVictimsQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->victimsScheduledForDeletion = null;
                }

            }

            if ($this->collVictims) {
                foreach ($this->collVictims as $victim) {
                    if (!$victim->isDeleted() && ($victim->isNew() || $victim->isModified())) {
                        $victim->save($con);
                    }
                }
            }


            if ($this->mailingsScheduledForDeletion !== null) {
                if (!$this->mailingsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->mailingsScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \DB\GroupMailingsQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->mailingsScheduledForDeletion = null;
                }

            }

            if ($this->collMailings) {
                foreach ($this->collMailings as $mailing) {
                    if (!$mailing->isDeleted() && ($mailing->isNew() || $mailing->isModified())) {
                        $mailing->save($con);
                    }
                }
            }


            if ($this->webVisitsScheduledForDeletion !== null) {
                if (!$this->webVisitsScheduledForDeletion->isEmpty()) {
                    foreach ($this->webVisitsScheduledForDeletion as $webVisit) {
                        // need to save related object because we set the relation to null
                        $webVisit->save($con);
                    }
                    $this->webVisitsScheduledForDeletion = null;
                }
            }

            if ($this->collWebVisits !== null) {
                foreach ($this->collWebVisits as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->webConversionsScheduledForDeletion !== null) {
                if (!$this->webConversionsScheduledForDeletion->isEmpty()) {
                    foreach ($this->webConversionsScheduledForDeletion as $webConversion) {
                        // need to save related object because we set the relation to null
                        $webConversion->save($con);
                    }
                    $this->webConversionsScheduledForDeletion = null;
                }
            }

            if ($this->collWebConversions !== null) {
                foreach ($this->collWebConversions as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->userGroupssScheduledForDeletion !== null) {
                if (!$this->userGroupssScheduledForDeletion->isEmpty()) {
                    \DB\UserGroupsQuery::create()
                        ->filterByPrimaryKeys($this->userGroupssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->userGroupssScheduledForDeletion = null;
                }
            }

            if ($this->collUserGroupss !== null) {
                foreach ($this->collUserGroupss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->groupVictimssScheduledForDeletion !== null) {
                if (!$this->groupVictimssScheduledForDeletion->isEmpty()) {
                    \DB\GroupVictimsQuery::create()
                        ->filterByPrimaryKeys($this->groupVictimssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->groupVictimssScheduledForDeletion = null;
                }
            }

            if ($this->collGroupVictimss !== null) {
                foreach ($this->collGroupVictimss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->victimMailingssScheduledForDeletion !== null) {
                if (!$this->victimMailingssScheduledForDeletion->isEmpty()) {
                    foreach ($this->victimMailingssScheduledForDeletion as $victimMailings) {
                        // need to save related object because we set the relation to null
                        $victimMailings->save($con);
                    }
                    $this->victimMailingssScheduledForDeletion = null;
                }
            }

            if ($this->collVictimMailingss !== null) {
                foreach ($this->collVictimMailingss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->groupMailingssScheduledForDeletion !== null) {
                if (!$this->groupMailingssScheduledForDeletion->isEmpty()) {
                    \DB\GroupMailingsQuery::create()
                        ->filterByPrimaryKeys($this->groupMailingssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->groupMailingssScheduledForDeletion = null;
                }
            }

            if ($this->collGroupMailingss !== null) {
                foreach ($this->collGroupMailingss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[GroupTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . GroupTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(GroupTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(GroupTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(GroupTableMap::COL_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = 'description';
        }

        $sql = sprintf(
            'INSERT INTO Groups (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'description':
                        $stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = GroupTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getName();
                break;
            case 2:
                return $this->getDescription();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Group'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Group'][$this->hashCode()] = true;
        $keys = GroupTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getDescription(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collWebVisits) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'webVisits';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'WebVisitss';
                        break;
                    default:
                        $key = 'WebVisits';
                }

                $result[$key] = $this->collWebVisits->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collWebConversions) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'webConversions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'WebConversionss';
                        break;
                    default:
                        $key = 'WebConversions';
                }

                $result[$key] = $this->collWebConversions->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collUserGroupss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'userGroupss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'User_Groupss';
                        break;
                    default:
                        $key = 'UserGroupss';
                }

                $result[$key] = $this->collUserGroupss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collGroupVictimss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'groupVictimss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'Group_Victimss';
                        break;
                    default:
                        $key = 'GroupVictimss';
                }

                $result[$key] = $this->collGroupVictimss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collVictimMailingss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'victimMailingss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'Victim_Mailingss';
                        break;
                    default:
                        $key = 'VictimMailingss';
                }

                $result[$key] = $this->collVictimMailingss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collGroupMailingss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'groupMailingss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'Group_Mailingss';
                        break;
                    default:
                        $key = 'GroupMailingss';
                }

                $result[$key] = $this->collGroupMailingss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\DB\Group
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = GroupTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\DB\Group
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setDescription($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = GroupTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setDescription($arr[$keys[2]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\DB\Group The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(GroupTableMap::DATABASE_NAME);

        if ($this->isColumnModified(GroupTableMap::COL_ID)) {
            $criteria->add(GroupTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(GroupTableMap::COL_NAME)) {
            $criteria->add(GroupTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(GroupTableMap::COL_DESCRIPTION)) {
            $criteria->add(GroupTableMap::COL_DESCRIPTION, $this->description);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildGroupQuery::create();
        $criteria->add(GroupTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \DB\Group (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setDescription($this->getDescription());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getWebVisits() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addWebVisit($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getWebConversions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addWebConversion($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getUserGroupss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addUserGroups($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getGroupVictimss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addGroupVictims($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getVictimMailingss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addVictimMailings($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getGroupMailingss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addGroupMailings($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \DB\Group Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('WebVisit' == $relationName) {
            $this->initWebVisits();
            return;
        }
        if ('WebConversion' == $relationName) {
            $this->initWebConversions();
            return;
        }
        if ('UserGroups' == $relationName) {
            $this->initUserGroupss();
            return;
        }
        if ('GroupVictims' == $relationName) {
            $this->initGroupVictimss();
            return;
        }
        if ('VictimMailings' == $relationName) {
            $this->initVictimMailingss();
            return;
        }
        if ('GroupMailings' == $relationName) {
            $this->initGroupMailingss();
            return;
        }
    }

    /**
     * Clears out the collWebVisits collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addWebVisits()
     */
    public function clearWebVisits()
    {
        $this->collWebVisits = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collWebVisits collection loaded partially.
     */
    public function resetPartialWebVisits($v = true)
    {
        $this->collWebVisitsPartial = $v;
    }

    /**
     * Initializes the collWebVisits collection.
     *
     * By default this just sets the collWebVisits collection to an empty array (like clearcollWebVisits());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initWebVisits($overrideExisting = true)
    {
        if (null !== $this->collWebVisits && !$overrideExisting) {
            return;
        }

        $collectionClassName = WebVisitTableMap::getTableMap()->getCollectionClassName();

        $this->collWebVisits = new $collectionClassName;
        $this->collWebVisits->setModel('\DB\WebVisit');
    }

    /**
     * Gets an array of ChildWebVisit objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildGroup is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildWebVisit[] List of ChildWebVisit objects
     * @throws PropelException
     */
    public function getWebVisits(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collWebVisitsPartial && !$this->isNew();
        if (null === $this->collWebVisits || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collWebVisits) {
                // return empty collection
                $this->initWebVisits();
            } else {
                $collWebVisits = ChildWebVisitQuery::create(null, $criteria)
                    ->filterByGroup($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collWebVisitsPartial && count($collWebVisits)) {
                        $this->initWebVisits(false);

                        foreach ($collWebVisits as $obj) {
                            if (false == $this->collWebVisits->contains($obj)) {
                                $this->collWebVisits->append($obj);
                            }
                        }

                        $this->collWebVisitsPartial = true;
                    }

                    return $collWebVisits;
                }

                if ($partial && $this->collWebVisits) {
                    foreach ($this->collWebVisits as $obj) {
                        if ($obj->isNew()) {
                            $collWebVisits[] = $obj;
                        }
                    }
                }

                $this->collWebVisits = $collWebVisits;
                $this->collWebVisitsPartial = false;
            }
        }

        return $this->collWebVisits;
    }

    /**
     * Sets a collection of ChildWebVisit objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $webVisits A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildGroup The current object (for fluent API support)
     */
    public function setWebVisits(Collection $webVisits, ConnectionInterface $con = null)
    {
        /** @var ChildWebVisit[] $webVisitsToDelete */
        $webVisitsToDelete = $this->getWebVisits(new Criteria(), $con)->diff($webVisits);


        $this->webVisitsScheduledForDeletion = $webVisitsToDelete;

        foreach ($webVisitsToDelete as $webVisitRemoved) {
            $webVisitRemoved->setGroup(null);
        }

        $this->collWebVisits = null;
        foreach ($webVisits as $webVisit) {
            $this->addWebVisit($webVisit);
        }

        $this->collWebVisits = $webVisits;
        $this->collWebVisitsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related WebVisit objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related WebVisit objects.
     * @throws PropelException
     */
    public function countWebVisits(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collWebVisitsPartial && !$this->isNew();
        if (null === $this->collWebVisits || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collWebVisits) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getWebVisits());
            }

            $query = ChildWebVisitQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByGroup($this)
                ->count($con);
        }

        return count($this->collWebVisits);
    }

    /**
     * Method called to associate a ChildWebVisit object to this object
     * through the ChildWebVisit foreign key attribute.
     *
     * @param  ChildWebVisit $l ChildWebVisit
     * @return $this|\DB\Group The current object (for fluent API support)
     */
    public function addWebVisit(ChildWebVisit $l)
    {
        if ($this->collWebVisits === null) {
            $this->initWebVisits();
            $this->collWebVisitsPartial = true;
        }

        if (!$this->collWebVisits->contains($l)) {
            $this->doAddWebVisit($l);

            if ($this->webVisitsScheduledForDeletion and $this->webVisitsScheduledForDeletion->contains($l)) {
                $this->webVisitsScheduledForDeletion->remove($this->webVisitsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildWebVisit $webVisit The ChildWebVisit object to add.
     */
    protected function doAddWebVisit(ChildWebVisit $webVisit)
    {
        $this->collWebVisits[]= $webVisit;
        $webVisit->setGroup($this);
    }

    /**
     * @param  ChildWebVisit $webVisit The ChildWebVisit object to remove.
     * @return $this|ChildGroup The current object (for fluent API support)
     */
    public function removeWebVisit(ChildWebVisit $webVisit)
    {
        if ($this->getWebVisits()->contains($webVisit)) {
            $pos = $this->collWebVisits->search($webVisit);
            $this->collWebVisits->remove($pos);
            if (null === $this->webVisitsScheduledForDeletion) {
                $this->webVisitsScheduledForDeletion = clone $this->collWebVisits;
                $this->webVisitsScheduledForDeletion->clear();
            }
            $this->webVisitsScheduledForDeletion[]= $webVisit;
            $webVisit->setGroup(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Group is new, it will return
     * an empty collection; or if this Group has previously
     * been saved, it will retrieve related WebVisits from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Group.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildWebVisit[] List of ChildWebVisit objects
     */
    public function getWebVisitsJoinMailing(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildWebVisitQuery::create(null, $criteria);
        $query->joinWith('Mailing', $joinBehavior);

        return $this->getWebVisits($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Group is new, it will return
     * an empty collection; or if this Group has previously
     * been saved, it will retrieve related WebVisits from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Group.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildWebVisit[] List of ChildWebVisit objects
     */
    public function getWebVisitsJoinVictim(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildWebVisitQuery::create(null, $criteria);
        $query->joinWith('Victim', $joinBehavior);

        return $this->getWebVisits($query, $con);
    }

    /**
     * Clears out the collWebConversions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addWebConversions()
     */
    public function clearWebConversions()
    {
        $this->collWebConversions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collWebConversions collection loaded partially.
     */
    public function resetPartialWebConversions($v = true)
    {
        $this->collWebConversionsPartial = $v;
    }

    /**
     * Initializes the collWebConversions collection.
     *
     * By default this just sets the collWebConversions collection to an empty array (like clearcollWebConversions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initWebConversions($overrideExisting = true)
    {
        if (null !== $this->collWebConversions && !$overrideExisting) {
            return;
        }

        $collectionClassName = WebConversionTableMap::getTableMap()->getCollectionClassName();

        $this->collWebConversions = new $collectionClassName;
        $this->collWebConversions->setModel('\DB\WebConversion');
    }

    /**
     * Gets an array of ChildWebConversion objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildGroup is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildWebConversion[] List of ChildWebConversion objects
     * @throws PropelException
     */
    public function getWebConversions(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collWebConversionsPartial && !$this->isNew();
        if (null === $this->collWebConversions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collWebConversions) {
                // return empty collection
                $this->initWebConversions();
            } else {
                $collWebConversions = ChildWebConversionQuery::create(null, $criteria)
                    ->filterByGroup($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collWebConversionsPartial && count($collWebConversions)) {
                        $this->initWebConversions(false);

                        foreach ($collWebConversions as $obj) {
                            if (false == $this->collWebConversions->contains($obj)) {
                                $this->collWebConversions->append($obj);
                            }
                        }

                        $this->collWebConversionsPartial = true;
                    }

                    return $collWebConversions;
                }

                if ($partial && $this->collWebConversions) {
                    foreach ($this->collWebConversions as $obj) {
                        if ($obj->isNew()) {
                            $collWebConversions[] = $obj;
                        }
                    }
                }

                $this->collWebConversions = $collWebConversions;
                $this->collWebConversionsPartial = false;
            }
        }

        return $this->collWebConversions;
    }

    /**
     * Sets a collection of ChildWebConversion objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $webConversions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildGroup The current object (for fluent API support)
     */
    public function setWebConversions(Collection $webConversions, ConnectionInterface $con = null)
    {
        /** @var ChildWebConversion[] $webConversionsToDelete */
        $webConversionsToDelete = $this->getWebConversions(new Criteria(), $con)->diff($webConversions);


        $this->webConversionsScheduledForDeletion = $webConversionsToDelete;

        foreach ($webConversionsToDelete as $webConversionRemoved) {
            $webConversionRemoved->setGroup(null);
        }

        $this->collWebConversions = null;
        foreach ($webConversions as $webConversion) {
            $this->addWebConversion($webConversion);
        }

        $this->collWebConversions = $webConversions;
        $this->collWebConversionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related WebConversion objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related WebConversion objects.
     * @throws PropelException
     */
    public function countWebConversions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collWebConversionsPartial && !$this->isNew();
        if (null === $this->collWebConversions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collWebConversions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getWebConversions());
            }

            $query = ChildWebConversionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByGroup($this)
                ->count($con);
        }

        return count($this->collWebConversions);
    }

    /**
     * Method called to associate a ChildWebConversion object to this object
     * through the ChildWebConversion foreign key attribute.
     *
     * @param  ChildWebConversion $l ChildWebConversion
     * @return $this|\DB\Group The current object (for fluent API support)
     */
    public function addWebConversion(ChildWebConversion $l)
    {
        if ($this->collWebConversions === null) {
            $this->initWebConversions();
            $this->collWebConversionsPartial = true;
        }

        if (!$this->collWebConversions->contains($l)) {
            $this->doAddWebConversion($l);

            if ($this->webConversionsScheduledForDeletion and $this->webConversionsScheduledForDeletion->contains($l)) {
                $this->webConversionsScheduledForDeletion->remove($this->webConversionsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildWebConversion $webConversion The ChildWebConversion object to add.
     */
    protected function doAddWebConversion(ChildWebConversion $webConversion)
    {
        $this->collWebConversions[]= $webConversion;
        $webConversion->setGroup($this);
    }

    /**
     * @param  ChildWebConversion $webConversion The ChildWebConversion object to remove.
     * @return $this|ChildGroup The current object (for fluent API support)
     */
    public function removeWebConversion(ChildWebConversion $webConversion)
    {
        if ($this->getWebConversions()->contains($webConversion)) {
            $pos = $this->collWebConversions->search($webConversion);
            $this->collWebConversions->remove($pos);
            if (null === $this->webConversionsScheduledForDeletion) {
                $this->webConversionsScheduledForDeletion = clone $this->collWebConversions;
                $this->webConversionsScheduledForDeletion->clear();
            }
            $this->webConversionsScheduledForDeletion[]= $webConversion;
            $webConversion->setGroup(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Group is new, it will return
     * an empty collection; or if this Group has previously
     * been saved, it will retrieve related WebConversions from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Group.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildWebConversion[] List of ChildWebConversion objects
     */
    public function getWebConversionsJoinMailing(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildWebConversionQuery::create(null, $criteria);
        $query->joinWith('Mailing', $joinBehavior);

        return $this->getWebConversions($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Group is new, it will return
     * an empty collection; or if this Group has previously
     * been saved, it will retrieve related WebConversions from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Group.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildWebConversion[] List of ChildWebConversion objects
     */
    public function getWebConversionsJoinVictim(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildWebConversionQuery::create(null, $criteria);
        $query->joinWith('Victim', $joinBehavior);

        return $this->getWebConversions($query, $con);
    }

    /**
     * Clears out the collUserGroupss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addUserGroupss()
     */
    public function clearUserGroupss()
    {
        $this->collUserGroupss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collUserGroupss collection loaded partially.
     */
    public function resetPartialUserGroupss($v = true)
    {
        $this->collUserGroupssPartial = $v;
    }

    /**
     * Initializes the collUserGroupss collection.
     *
     * By default this just sets the collUserGroupss collection to an empty array (like clearcollUserGroupss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUserGroupss($overrideExisting = true)
    {
        if (null !== $this->collUserGroupss && !$overrideExisting) {
            return;
        }

        $collectionClassName = UserGroupsTableMap::getTableMap()->getCollectionClassName();

        $this->collUserGroupss = new $collectionClassName;
        $this->collUserGroupss->setModel('\DB\UserGroups');
    }

    /**
     * Gets an array of ChildUserGroups objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildGroup is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildUserGroups[] List of ChildUserGroups objects
     * @throws PropelException
     */
    public function getUserGroupss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collUserGroupssPartial && !$this->isNew();
        if (null === $this->collUserGroupss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collUserGroupss) {
                // return empty collection
                $this->initUserGroupss();
            } else {
                $collUserGroupss = ChildUserGroupsQuery::create(null, $criteria)
                    ->filterByGroup($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collUserGroupssPartial && count($collUserGroupss)) {
                        $this->initUserGroupss(false);

                        foreach ($collUserGroupss as $obj) {
                            if (false == $this->collUserGroupss->contains($obj)) {
                                $this->collUserGroupss->append($obj);
                            }
                        }

                        $this->collUserGroupssPartial = true;
                    }

                    return $collUserGroupss;
                }

                if ($partial && $this->collUserGroupss) {
                    foreach ($this->collUserGroupss as $obj) {
                        if ($obj->isNew()) {
                            $collUserGroupss[] = $obj;
                        }
                    }
                }

                $this->collUserGroupss = $collUserGroupss;
                $this->collUserGroupssPartial = false;
            }
        }

        return $this->collUserGroupss;
    }

    /**
     * Sets a collection of ChildUserGroups objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $userGroupss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildGroup The current object (for fluent API support)
     */
    public function setUserGroupss(Collection $userGroupss, ConnectionInterface $con = null)
    {
        /** @var ChildUserGroups[] $userGroupssToDelete */
        $userGroupssToDelete = $this->getUserGroupss(new Criteria(), $con)->diff($userGroupss);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->userGroupssScheduledForDeletion = clone $userGroupssToDelete;

        foreach ($userGroupssToDelete as $userGroupsRemoved) {
            $userGroupsRemoved->setGroup(null);
        }

        $this->collUserGroupss = null;
        foreach ($userGroupss as $userGroups) {
            $this->addUserGroups($userGroups);
        }

        $this->collUserGroupss = $userGroupss;
        $this->collUserGroupssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related UserGroups objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related UserGroups objects.
     * @throws PropelException
     */
    public function countUserGroupss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collUserGroupssPartial && !$this->isNew();
        if (null === $this->collUserGroupss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUserGroupss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getUserGroupss());
            }

            $query = ChildUserGroupsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByGroup($this)
                ->count($con);
        }

        return count($this->collUserGroupss);
    }

    /**
     * Method called to associate a ChildUserGroups object to this object
     * through the ChildUserGroups foreign key attribute.
     *
     * @param  ChildUserGroups $l ChildUserGroups
     * @return $this|\DB\Group The current object (for fluent API support)
     */
    public function addUserGroups(ChildUserGroups $l)
    {
        if ($this->collUserGroupss === null) {
            $this->initUserGroupss();
            $this->collUserGroupssPartial = true;
        }

        if (!$this->collUserGroupss->contains($l)) {
            $this->doAddUserGroups($l);

            if ($this->userGroupssScheduledForDeletion and $this->userGroupssScheduledForDeletion->contains($l)) {
                $this->userGroupssScheduledForDeletion->remove($this->userGroupssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildUserGroups $userGroups The ChildUserGroups object to add.
     */
    protected function doAddUserGroups(ChildUserGroups $userGroups)
    {
        $this->collUserGroupss[]= $userGroups;
        $userGroups->setGroup($this);
    }

    /**
     * @param  ChildUserGroups $userGroups The ChildUserGroups object to remove.
     * @return $this|ChildGroup The current object (for fluent API support)
     */
    public function removeUserGroups(ChildUserGroups $userGroups)
    {
        if ($this->getUserGroupss()->contains($userGroups)) {
            $pos = $this->collUserGroupss->search($userGroups);
            $this->collUserGroupss->remove($pos);
            if (null === $this->userGroupssScheduledForDeletion) {
                $this->userGroupssScheduledForDeletion = clone $this->collUserGroupss;
                $this->userGroupssScheduledForDeletion->clear();
            }
            $this->userGroupssScheduledForDeletion[]= clone $userGroups;
            $userGroups->setGroup(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Group is new, it will return
     * an empty collection; or if this Group has previously
     * been saved, it will retrieve related UserGroupss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Group.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildUserGroups[] List of ChildUserGroups objects
     */
    public function getUserGroupssJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildUserGroupsQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getUserGroupss($query, $con);
    }

    /**
     * Clears out the collGroupVictimss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addGroupVictimss()
     */
    public function clearGroupVictimss()
    {
        $this->collGroupVictimss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collGroupVictimss collection loaded partially.
     */
    public function resetPartialGroupVictimss($v = true)
    {
        $this->collGroupVictimssPartial = $v;
    }

    /**
     * Initializes the collGroupVictimss collection.
     *
     * By default this just sets the collGroupVictimss collection to an empty array (like clearcollGroupVictimss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initGroupVictimss($overrideExisting = true)
    {
        if (null !== $this->collGroupVictimss && !$overrideExisting) {
            return;
        }

        $collectionClassName = GroupVictimsTableMap::getTableMap()->getCollectionClassName();

        $this->collGroupVictimss = new $collectionClassName;
        $this->collGroupVictimss->setModel('\DB\GroupVictims');
    }

    /**
     * Gets an array of ChildGroupVictims objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildGroup is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildGroupVictims[] List of ChildGroupVictims objects
     * @throws PropelException
     */
    public function getGroupVictimss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collGroupVictimssPartial && !$this->isNew();
        if (null === $this->collGroupVictimss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collGroupVictimss) {
                // return empty collection
                $this->initGroupVictimss();
            } else {
                $collGroupVictimss = ChildGroupVictimsQuery::create(null, $criteria)
                    ->filterByGroup($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collGroupVictimssPartial && count($collGroupVictimss)) {
                        $this->initGroupVictimss(false);

                        foreach ($collGroupVictimss as $obj) {
                            if (false == $this->collGroupVictimss->contains($obj)) {
                                $this->collGroupVictimss->append($obj);
                            }
                        }

                        $this->collGroupVictimssPartial = true;
                    }

                    return $collGroupVictimss;
                }

                if ($partial && $this->collGroupVictimss) {
                    foreach ($this->collGroupVictimss as $obj) {
                        if ($obj->isNew()) {
                            $collGroupVictimss[] = $obj;
                        }
                    }
                }

                $this->collGroupVictimss = $collGroupVictimss;
                $this->collGroupVictimssPartial = false;
            }
        }

        return $this->collGroupVictimss;
    }

    /**
     * Sets a collection of ChildGroupVictims objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $groupVictimss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildGroup The current object (for fluent API support)
     */
    public function setGroupVictimss(Collection $groupVictimss, ConnectionInterface $con = null)
    {
        /** @var ChildGroupVictims[] $groupVictimssToDelete */
        $groupVictimssToDelete = $this->getGroupVictimss(new Criteria(), $con)->diff($groupVictimss);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->groupVictimssScheduledForDeletion = clone $groupVictimssToDelete;

        foreach ($groupVictimssToDelete as $groupVictimsRemoved) {
            $groupVictimsRemoved->setGroup(null);
        }

        $this->collGroupVictimss = null;
        foreach ($groupVictimss as $groupVictims) {
            $this->addGroupVictims($groupVictims);
        }

        $this->collGroupVictimss = $groupVictimss;
        $this->collGroupVictimssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related GroupVictims objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related GroupVictims objects.
     * @throws PropelException
     */
    public function countGroupVictimss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collGroupVictimssPartial && !$this->isNew();
        if (null === $this->collGroupVictimss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collGroupVictimss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getGroupVictimss());
            }

            $query = ChildGroupVictimsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByGroup($this)
                ->count($con);
        }

        return count($this->collGroupVictimss);
    }

    /**
     * Method called to associate a ChildGroupVictims object to this object
     * through the ChildGroupVictims foreign key attribute.
     *
     * @param  ChildGroupVictims $l ChildGroupVictims
     * @return $this|\DB\Group The current object (for fluent API support)
     */
    public function addGroupVictims(ChildGroupVictims $l)
    {
        if ($this->collGroupVictimss === null) {
            $this->initGroupVictimss();
            $this->collGroupVictimssPartial = true;
        }

        if (!$this->collGroupVictimss->contains($l)) {
            $this->doAddGroupVictims($l);

            if ($this->groupVictimssScheduledForDeletion and $this->groupVictimssScheduledForDeletion->contains($l)) {
                $this->groupVictimssScheduledForDeletion->remove($this->groupVictimssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildGroupVictims $groupVictims The ChildGroupVictims object to add.
     */
    protected function doAddGroupVictims(ChildGroupVictims $groupVictims)
    {
        $this->collGroupVictimss[]= $groupVictims;
        $groupVictims->setGroup($this);
    }

    /**
     * @param  ChildGroupVictims $groupVictims The ChildGroupVictims object to remove.
     * @return $this|ChildGroup The current object (for fluent API support)
     */
    public function removeGroupVictims(ChildGroupVictims $groupVictims)
    {
        if ($this->getGroupVictimss()->contains($groupVictims)) {
            $pos = $this->collGroupVictimss->search($groupVictims);
            $this->collGroupVictimss->remove($pos);
            if (null === $this->groupVictimssScheduledForDeletion) {
                $this->groupVictimssScheduledForDeletion = clone $this->collGroupVictimss;
                $this->groupVictimssScheduledForDeletion->clear();
            }
            $this->groupVictimssScheduledForDeletion[]= clone $groupVictims;
            $groupVictims->setGroup(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Group is new, it will return
     * an empty collection; or if this Group has previously
     * been saved, it will retrieve related GroupVictimss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Group.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGroupVictims[] List of ChildGroupVictims objects
     */
    public function getGroupVictimssJoinVictim(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGroupVictimsQuery::create(null, $criteria);
        $query->joinWith('Victim', $joinBehavior);

        return $this->getGroupVictimss($query, $con);
    }

    /**
     * Clears out the collVictimMailingss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addVictimMailingss()
     */
    public function clearVictimMailingss()
    {
        $this->collVictimMailingss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collVictimMailingss collection loaded partially.
     */
    public function resetPartialVictimMailingss($v = true)
    {
        $this->collVictimMailingssPartial = $v;
    }

    /**
     * Initializes the collVictimMailingss collection.
     *
     * By default this just sets the collVictimMailingss collection to an empty array (like clearcollVictimMailingss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initVictimMailingss($overrideExisting = true)
    {
        if (null !== $this->collVictimMailingss && !$overrideExisting) {
            return;
        }

        $collectionClassName = VictimMailingsTableMap::getTableMap()->getCollectionClassName();

        $this->collVictimMailingss = new $collectionClassName;
        $this->collVictimMailingss->setModel('\DB\VictimMailings');
    }

    /**
     * Gets an array of ChildVictimMailings objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildGroup is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildVictimMailings[] List of ChildVictimMailings objects
     * @throws PropelException
     */
    public function getVictimMailingss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collVictimMailingssPartial && !$this->isNew();
        if (null === $this->collVictimMailingss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collVictimMailingss) {
                // return empty collection
                $this->initVictimMailingss();
            } else {
                $collVictimMailingss = ChildVictimMailingsQuery::create(null, $criteria)
                    ->filterByGroup($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collVictimMailingssPartial && count($collVictimMailingss)) {
                        $this->initVictimMailingss(false);

                        foreach ($collVictimMailingss as $obj) {
                            if (false == $this->collVictimMailingss->contains($obj)) {
                                $this->collVictimMailingss->append($obj);
                            }
                        }

                        $this->collVictimMailingssPartial = true;
                    }

                    return $collVictimMailingss;
                }

                if ($partial && $this->collVictimMailingss) {
                    foreach ($this->collVictimMailingss as $obj) {
                        if ($obj->isNew()) {
                            $collVictimMailingss[] = $obj;
                        }
                    }
                }

                $this->collVictimMailingss = $collVictimMailingss;
                $this->collVictimMailingssPartial = false;
            }
        }

        return $this->collVictimMailingss;
    }

    /**
     * Sets a collection of ChildVictimMailings objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $victimMailingss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildGroup The current object (for fluent API support)
     */
    public function setVictimMailingss(Collection $victimMailingss, ConnectionInterface $con = null)
    {
        /** @var ChildVictimMailings[] $victimMailingssToDelete */
        $victimMailingssToDelete = $this->getVictimMailingss(new Criteria(), $con)->diff($victimMailingss);


        $this->victimMailingssScheduledForDeletion = $victimMailingssToDelete;

        foreach ($victimMailingssToDelete as $victimMailingsRemoved) {
            $victimMailingsRemoved->setGroup(null);
        }

        $this->collVictimMailingss = null;
        foreach ($victimMailingss as $victimMailings) {
            $this->addVictimMailings($victimMailings);
        }

        $this->collVictimMailingss = $victimMailingss;
        $this->collVictimMailingssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related VictimMailings objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related VictimMailings objects.
     * @throws PropelException
     */
    public function countVictimMailingss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collVictimMailingssPartial && !$this->isNew();
        if (null === $this->collVictimMailingss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collVictimMailingss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getVictimMailingss());
            }

            $query = ChildVictimMailingsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByGroup($this)
                ->count($con);
        }

        return count($this->collVictimMailingss);
    }

    /**
     * Method called to associate a ChildVictimMailings object to this object
     * through the ChildVictimMailings foreign key attribute.
     *
     * @param  ChildVictimMailings $l ChildVictimMailings
     * @return $this|\DB\Group The current object (for fluent API support)
     */
    public function addVictimMailings(ChildVictimMailings $l)
    {
        if ($this->collVictimMailingss === null) {
            $this->initVictimMailingss();
            $this->collVictimMailingssPartial = true;
        }

        if (!$this->collVictimMailingss->contains($l)) {
            $this->doAddVictimMailings($l);

            if ($this->victimMailingssScheduledForDeletion and $this->victimMailingssScheduledForDeletion->contains($l)) {
                $this->victimMailingssScheduledForDeletion->remove($this->victimMailingssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildVictimMailings $victimMailings The ChildVictimMailings object to add.
     */
    protected function doAddVictimMailings(ChildVictimMailings $victimMailings)
    {
        $this->collVictimMailingss[]= $victimMailings;
        $victimMailings->setGroup($this);
    }

    /**
     * @param  ChildVictimMailings $victimMailings The ChildVictimMailings object to remove.
     * @return $this|ChildGroup The current object (for fluent API support)
     */
    public function removeVictimMailings(ChildVictimMailings $victimMailings)
    {
        if ($this->getVictimMailingss()->contains($victimMailings)) {
            $pos = $this->collVictimMailingss->search($victimMailings);
            $this->collVictimMailingss->remove($pos);
            if (null === $this->victimMailingssScheduledForDeletion) {
                $this->victimMailingssScheduledForDeletion = clone $this->collVictimMailingss;
                $this->victimMailingssScheduledForDeletion->clear();
            }
            $this->victimMailingssScheduledForDeletion[]= $victimMailings;
            $victimMailings->setGroup(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Group is new, it will return
     * an empty collection; or if this Group has previously
     * been saved, it will retrieve related VictimMailingss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Group.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildVictimMailings[] List of ChildVictimMailings objects
     */
    public function getVictimMailingssJoinVictim(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildVictimMailingsQuery::create(null, $criteria);
        $query->joinWith('Victim', $joinBehavior);

        return $this->getVictimMailingss($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Group is new, it will return
     * an empty collection; or if this Group has previously
     * been saved, it will retrieve related VictimMailingss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Group.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildVictimMailings[] List of ChildVictimMailings objects
     */
    public function getVictimMailingssJoinMailing(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildVictimMailingsQuery::create(null, $criteria);
        $query->joinWith('Mailing', $joinBehavior);

        return $this->getVictimMailingss($query, $con);
    }

    /**
     * Clears out the collGroupMailingss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addGroupMailingss()
     */
    public function clearGroupMailingss()
    {
        $this->collGroupMailingss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collGroupMailingss collection loaded partially.
     */
    public function resetPartialGroupMailingss($v = true)
    {
        $this->collGroupMailingssPartial = $v;
    }

    /**
     * Initializes the collGroupMailingss collection.
     *
     * By default this just sets the collGroupMailingss collection to an empty array (like clearcollGroupMailingss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initGroupMailingss($overrideExisting = true)
    {
        if (null !== $this->collGroupMailingss && !$overrideExisting) {
            return;
        }

        $collectionClassName = GroupMailingsTableMap::getTableMap()->getCollectionClassName();

        $this->collGroupMailingss = new $collectionClassName;
        $this->collGroupMailingss->setModel('\DB\GroupMailings');
    }

    /**
     * Gets an array of ChildGroupMailings objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildGroup is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildGroupMailings[] List of ChildGroupMailings objects
     * @throws PropelException
     */
    public function getGroupMailingss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collGroupMailingssPartial && !$this->isNew();
        if (null === $this->collGroupMailingss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collGroupMailingss) {
                // return empty collection
                $this->initGroupMailingss();
            } else {
                $collGroupMailingss = ChildGroupMailingsQuery::create(null, $criteria)
                    ->filterByGroup($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collGroupMailingssPartial && count($collGroupMailingss)) {
                        $this->initGroupMailingss(false);

                        foreach ($collGroupMailingss as $obj) {
                            if (false == $this->collGroupMailingss->contains($obj)) {
                                $this->collGroupMailingss->append($obj);
                            }
                        }

                        $this->collGroupMailingssPartial = true;
                    }

                    return $collGroupMailingss;
                }

                if ($partial && $this->collGroupMailingss) {
                    foreach ($this->collGroupMailingss as $obj) {
                        if ($obj->isNew()) {
                            $collGroupMailingss[] = $obj;
                        }
                    }
                }

                $this->collGroupMailingss = $collGroupMailingss;
                $this->collGroupMailingssPartial = false;
            }
        }

        return $this->collGroupMailingss;
    }

    /**
     * Sets a collection of ChildGroupMailings objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $groupMailingss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildGroup The current object (for fluent API support)
     */
    public function setGroupMailingss(Collection $groupMailingss, ConnectionInterface $con = null)
    {
        /** @var ChildGroupMailings[] $groupMailingssToDelete */
        $groupMailingssToDelete = $this->getGroupMailingss(new Criteria(), $con)->diff($groupMailingss);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->groupMailingssScheduledForDeletion = clone $groupMailingssToDelete;

        foreach ($groupMailingssToDelete as $groupMailingsRemoved) {
            $groupMailingsRemoved->setGroup(null);
        }

        $this->collGroupMailingss = null;
        foreach ($groupMailingss as $groupMailings) {
            $this->addGroupMailings($groupMailings);
        }

        $this->collGroupMailingss = $groupMailingss;
        $this->collGroupMailingssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related GroupMailings objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related GroupMailings objects.
     * @throws PropelException
     */
    public function countGroupMailingss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collGroupMailingssPartial && !$this->isNew();
        if (null === $this->collGroupMailingss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collGroupMailingss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getGroupMailingss());
            }

            $query = ChildGroupMailingsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByGroup($this)
                ->count($con);
        }

        return count($this->collGroupMailingss);
    }

    /**
     * Method called to associate a ChildGroupMailings object to this object
     * through the ChildGroupMailings foreign key attribute.
     *
     * @param  ChildGroupMailings $l ChildGroupMailings
     * @return $this|\DB\Group The current object (for fluent API support)
     */
    public function addGroupMailings(ChildGroupMailings $l)
    {
        if ($this->collGroupMailingss === null) {
            $this->initGroupMailingss();
            $this->collGroupMailingssPartial = true;
        }

        if (!$this->collGroupMailingss->contains($l)) {
            $this->doAddGroupMailings($l);

            if ($this->groupMailingssScheduledForDeletion and $this->groupMailingssScheduledForDeletion->contains($l)) {
                $this->groupMailingssScheduledForDeletion->remove($this->groupMailingssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildGroupMailings $groupMailings The ChildGroupMailings object to add.
     */
    protected function doAddGroupMailings(ChildGroupMailings $groupMailings)
    {
        $this->collGroupMailingss[]= $groupMailings;
        $groupMailings->setGroup($this);
    }

    /**
     * @param  ChildGroupMailings $groupMailings The ChildGroupMailings object to remove.
     * @return $this|ChildGroup The current object (for fluent API support)
     */
    public function removeGroupMailings(ChildGroupMailings $groupMailings)
    {
        if ($this->getGroupMailingss()->contains($groupMailings)) {
            $pos = $this->collGroupMailingss->search($groupMailings);
            $this->collGroupMailingss->remove($pos);
            if (null === $this->groupMailingssScheduledForDeletion) {
                $this->groupMailingssScheduledForDeletion = clone $this->collGroupMailingss;
                $this->groupMailingssScheduledForDeletion->clear();
            }
            $this->groupMailingssScheduledForDeletion[]= clone $groupMailings;
            $groupMailings->setGroup(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Group is new, it will return
     * an empty collection; or if this Group has previously
     * been saved, it will retrieve related GroupMailingss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Group.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGroupMailings[] List of ChildGroupMailings objects
     */
    public function getGroupMailingssJoinMailing(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGroupMailingsQuery::create(null, $criteria);
        $query->joinWith('Mailing', $joinBehavior);

        return $this->getGroupMailingss($query, $con);
    }

    /**
     * Clears out the collUsers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addUsers()
     */
    public function clearUsers()
    {
        $this->collUsers = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collUsers crossRef collection.
     *
     * By default this just sets the collUsers collection to an empty collection (like clearUsers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initUsers()
    {
        $collectionClassName = UserGroupsTableMap::getTableMap()->getCollectionClassName();

        $this->collUsers = new $collectionClassName;
        $this->collUsersPartial = true;
        $this->collUsers->setModel('\DB\User');
    }

    /**
     * Checks if the collUsers collection is loaded.
     *
     * @return bool
     */
    public function isUsersLoaded()
    {
        return null !== $this->collUsers;
    }

    /**
     * Gets a collection of ChildUser objects related by a many-to-many relationship
     * to the current object by way of the User_Groups cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildGroup is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildUser[] List of ChildUser objects
     */
    public function getUsers(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collUsersPartial && !$this->isNew();
        if (null === $this->collUsers || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collUsers) {
                    $this->initUsers();
                }
            } else {

                $query = ChildUserQuery::create(null, $criteria)
                    ->filterByGroup($this);
                $collUsers = $query->find($con);
                if (null !== $criteria) {
                    return $collUsers;
                }

                if ($partial && $this->collUsers) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collUsers as $obj) {
                        if (!$collUsers->contains($obj)) {
                            $collUsers[] = $obj;
                        }
                    }
                }

                $this->collUsers = $collUsers;
                $this->collUsersPartial = false;
            }
        }

        return $this->collUsers;
    }

    /**
     * Sets a collection of User objects related by a many-to-many relationship
     * to the current object by way of the User_Groups cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $users A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildGroup The current object (for fluent API support)
     */
    public function setUsers(Collection $users, ConnectionInterface $con = null)
    {
        $this->clearUsers();
        $currentUsers = $this->getUsers();

        $usersScheduledForDeletion = $currentUsers->diff($users);

        foreach ($usersScheduledForDeletion as $toDelete) {
            $this->removeUser($toDelete);
        }

        foreach ($users as $user) {
            if (!$currentUsers->contains($user)) {
                $this->doAddUser($user);
            }
        }

        $this->collUsersPartial = false;
        $this->collUsers = $users;

        return $this;
    }

    /**
     * Gets the number of User objects related by a many-to-many relationship
     * to the current object by way of the User_Groups cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related User objects
     */
    public function countUsers(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collUsersPartial && !$this->isNew();
        if (null === $this->collUsers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUsers) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getUsers());
                }

                $query = ChildUserQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByGroup($this)
                    ->count($con);
            }
        } else {
            return count($this->collUsers);
        }
    }

    /**
     * Associate a ChildUser to this object
     * through the User_Groups cross reference table.
     *
     * @param ChildUser $user
     * @return ChildGroup The current object (for fluent API support)
     */
    public function addUser(ChildUser $user)
    {
        if ($this->collUsers === null) {
            $this->initUsers();
        }

        if (!$this->getUsers()->contains($user)) {
            // only add it if the **same** object is not already associated
            $this->collUsers->push($user);
            $this->doAddUser($user);
        }

        return $this;
    }

    /**
     *
     * @param ChildUser $user
     */
    protected function doAddUser(ChildUser $user)
    {
        $userGroups = new ChildUserGroups();

        $userGroups->setUser($user);

        $userGroups->setGroup($this);

        $this->addUserGroups($userGroups);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$user->isGroupsLoaded()) {
            $user->initGroups();
            $user->getGroups()->push($this);
        } elseif (!$user->getGroups()->contains($this)) {
            $user->getGroups()->push($this);
        }

    }

    /**
     * Remove user of this object
     * through the User_Groups cross reference table.
     *
     * @param ChildUser $user
     * @return ChildGroup The current object (for fluent API support)
     */
    public function removeUser(ChildUser $user)
    {
        if ($this->getUsers()->contains($user)) {
            $userGroups = new ChildUserGroups();
            $userGroups->setUser($user);
            if ($user->isGroupsLoaded()) {
                //remove the back reference if available
                $user->getGroups()->removeObject($this);
            }

            $userGroups->setGroup($this);
            $this->removeUserGroups(clone $userGroups);
            $userGroups->clear();

            $this->collUsers->remove($this->collUsers->search($user));

            if (null === $this->usersScheduledForDeletion) {
                $this->usersScheduledForDeletion = clone $this->collUsers;
                $this->usersScheduledForDeletion->clear();
            }

            $this->usersScheduledForDeletion->push($user);
        }


        return $this;
    }

    /**
     * Clears out the collVictims collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addVictims()
     */
    public function clearVictims()
    {
        $this->collVictims = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collVictims crossRef collection.
     *
     * By default this just sets the collVictims collection to an empty collection (like clearVictims());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initVictims()
    {
        $collectionClassName = GroupVictimsTableMap::getTableMap()->getCollectionClassName();

        $this->collVictims = new $collectionClassName;
        $this->collVictimsPartial = true;
        $this->collVictims->setModel('\DB\Victim');
    }

    /**
     * Checks if the collVictims collection is loaded.
     *
     * @return bool
     */
    public function isVictimsLoaded()
    {
        return null !== $this->collVictims;
    }

    /**
     * Gets a collection of ChildVictim objects related by a many-to-many relationship
     * to the current object by way of the Group_Victims cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildGroup is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildVictim[] List of ChildVictim objects
     */
    public function getVictims(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collVictimsPartial && !$this->isNew();
        if (null === $this->collVictims || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collVictims) {
                    $this->initVictims();
                }
            } else {

                $query = ChildVictimQuery::create(null, $criteria)
                    ->filterByGroup($this);
                $collVictims = $query->find($con);
                if (null !== $criteria) {
                    return $collVictims;
                }

                if ($partial && $this->collVictims) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collVictims as $obj) {
                        if (!$collVictims->contains($obj)) {
                            $collVictims[] = $obj;
                        }
                    }
                }

                $this->collVictims = $collVictims;
                $this->collVictimsPartial = false;
            }
        }

        return $this->collVictims;
    }

    /**
     * Sets a collection of Victim objects related by a many-to-many relationship
     * to the current object by way of the Group_Victims cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $victims A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildGroup The current object (for fluent API support)
     */
    public function setVictims(Collection $victims, ConnectionInterface $con = null)
    {
        $this->clearVictims();
        $currentVictims = $this->getVictims();

        $victimsScheduledForDeletion = $currentVictims->diff($victims);

        foreach ($victimsScheduledForDeletion as $toDelete) {
            $this->removeVictim($toDelete);
        }

        foreach ($victims as $victim) {
            if (!$currentVictims->contains($victim)) {
                $this->doAddVictim($victim);
            }
        }

        $this->collVictimsPartial = false;
        $this->collVictims = $victims;

        return $this;
    }

    /**
     * Gets the number of Victim objects related by a many-to-many relationship
     * to the current object by way of the Group_Victims cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Victim objects
     */
    public function countVictims(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collVictimsPartial && !$this->isNew();
        if (null === $this->collVictims || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collVictims) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getVictims());
                }

                $query = ChildVictimQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByGroup($this)
                    ->count($con);
            }
        } else {
            return count($this->collVictims);
        }
    }

    /**
     * Associate a ChildVictim to this object
     * through the Group_Victims cross reference table.
     *
     * @param ChildVictim $victim
     * @return ChildGroup The current object (for fluent API support)
     */
    public function addVictim(ChildVictim $victim)
    {
        if ($this->collVictims === null) {
            $this->initVictims();
        }

        if (!$this->getVictims()->contains($victim)) {
            // only add it if the **same** object is not already associated
            $this->collVictims->push($victim);
            $this->doAddVictim($victim);
        }

        return $this;
    }

    /**
     *
     * @param ChildVictim $victim
     */
    protected function doAddVictim(ChildVictim $victim)
    {
        $groupVictims = new ChildGroupVictims();

        $groupVictims->setVictim($victim);

        $groupVictims->setGroup($this);

        $this->addGroupVictims($groupVictims);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$victim->isGroupsLoaded()) {
            $victim->initGroups();
            $victim->getGroups()->push($this);
        } elseif (!$victim->getGroups()->contains($this)) {
            $victim->getGroups()->push($this);
        }

    }

    /**
     * Remove victim of this object
     * through the Group_Victims cross reference table.
     *
     * @param ChildVictim $victim
     * @return ChildGroup The current object (for fluent API support)
     */
    public function removeVictim(ChildVictim $victim)
    {
        if ($this->getVictims()->contains($victim)) {
            $groupVictims = new ChildGroupVictims();
            $groupVictims->setVictim($victim);
            if ($victim->isGroupsLoaded()) {
                //remove the back reference if available
                $victim->getGroups()->removeObject($this);
            }

            $groupVictims->setGroup($this);
            $this->removeGroupVictims(clone $groupVictims);
            $groupVictims->clear();

            $this->collVictims->remove($this->collVictims->search($victim));

            if (null === $this->victimsScheduledForDeletion) {
                $this->victimsScheduledForDeletion = clone $this->collVictims;
                $this->victimsScheduledForDeletion->clear();
            }

            $this->victimsScheduledForDeletion->push($victim);
        }


        return $this;
    }

    /**
     * Clears out the collMailings collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addMailings()
     */
    public function clearMailings()
    {
        $this->collMailings = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collMailings crossRef collection.
     *
     * By default this just sets the collMailings collection to an empty collection (like clearMailings());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initMailings()
    {
        $collectionClassName = GroupMailingsTableMap::getTableMap()->getCollectionClassName();

        $this->collMailings = new $collectionClassName;
        $this->collMailingsPartial = true;
        $this->collMailings->setModel('\DB\Mailing');
    }

    /**
     * Checks if the collMailings collection is loaded.
     *
     * @return bool
     */
    public function isMailingsLoaded()
    {
        return null !== $this->collMailings;
    }

    /**
     * Gets a collection of ChildMailing objects related by a many-to-many relationship
     * to the current object by way of the Group_Mailings cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildGroup is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildMailing[] List of ChildMailing objects
     */
    public function getMailings(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collMailingsPartial && !$this->isNew();
        if (null === $this->collMailings || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collMailings) {
                    $this->initMailings();
                }
            } else {

                $query = ChildMailingQuery::create(null, $criteria)
                    ->filterByGroup($this);
                $collMailings = $query->find($con);
                if (null !== $criteria) {
                    return $collMailings;
                }

                if ($partial && $this->collMailings) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collMailings as $obj) {
                        if (!$collMailings->contains($obj)) {
                            $collMailings[] = $obj;
                        }
                    }
                }

                $this->collMailings = $collMailings;
                $this->collMailingsPartial = false;
            }
        }

        return $this->collMailings;
    }

    /**
     * Sets a collection of Mailing objects related by a many-to-many relationship
     * to the current object by way of the Group_Mailings cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $mailings A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildGroup The current object (for fluent API support)
     */
    public function setMailings(Collection $mailings, ConnectionInterface $con = null)
    {
        $this->clearMailings();
        $currentMailings = $this->getMailings();

        $mailingsScheduledForDeletion = $currentMailings->diff($mailings);

        foreach ($mailingsScheduledForDeletion as $toDelete) {
            $this->removeMailing($toDelete);
        }

        foreach ($mailings as $mailing) {
            if (!$currentMailings->contains($mailing)) {
                $this->doAddMailing($mailing);
            }
        }

        $this->collMailingsPartial = false;
        $this->collMailings = $mailings;

        return $this;
    }

    /**
     * Gets the number of Mailing objects related by a many-to-many relationship
     * to the current object by way of the Group_Mailings cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Mailing objects
     */
    public function countMailings(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collMailingsPartial && !$this->isNew();
        if (null === $this->collMailings || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMailings) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getMailings());
                }

                $query = ChildMailingQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByGroup($this)
                    ->count($con);
            }
        } else {
            return count($this->collMailings);
        }
    }

    /**
     * Associate a ChildMailing to this object
     * through the Group_Mailings cross reference table.
     *
     * @param ChildMailing $mailing
     * @return ChildGroup The current object (for fluent API support)
     */
    public function addMailing(ChildMailing $mailing)
    {
        if ($this->collMailings === null) {
            $this->initMailings();
        }

        if (!$this->getMailings()->contains($mailing)) {
            // only add it if the **same** object is not already associated
            $this->collMailings->push($mailing);
            $this->doAddMailing($mailing);
        }

        return $this;
    }

    /**
     *
     * @param ChildMailing $mailing
     */
    protected function doAddMailing(ChildMailing $mailing)
    {
        $groupMailings = new ChildGroupMailings();

        $groupMailings->setMailing($mailing);

        $groupMailings->setGroup($this);

        $this->addGroupMailings($groupMailings);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$mailing->isGroupsLoaded()) {
            $mailing->initGroups();
            $mailing->getGroups()->push($this);
        } elseif (!$mailing->getGroups()->contains($this)) {
            $mailing->getGroups()->push($this);
        }

    }

    /**
     * Remove mailing of this object
     * through the Group_Mailings cross reference table.
     *
     * @param ChildMailing $mailing
     * @return ChildGroup The current object (for fluent API support)
     */
    public function removeMailing(ChildMailing $mailing)
    {
        if ($this->getMailings()->contains($mailing)) {
            $groupMailings = new ChildGroupMailings();
            $groupMailings->setMailing($mailing);
            if ($mailing->isGroupsLoaded()) {
                //remove the back reference if available
                $mailing->getGroups()->removeObject($this);
            }

            $groupMailings->setGroup($this);
            $this->removeGroupMailings(clone $groupMailings);
            $groupMailings->clear();

            $this->collMailings->remove($this->collMailings->search($mailing));

            if (null === $this->mailingsScheduledForDeletion) {
                $this->mailingsScheduledForDeletion = clone $this->collMailings;
                $this->mailingsScheduledForDeletion->clear();
            }

            $this->mailingsScheduledForDeletion->push($mailing);
        }


        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->name = null;
        $this->description = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collWebVisits) {
                foreach ($this->collWebVisits as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collWebConversions) {
                foreach ($this->collWebConversions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUserGroupss) {
                foreach ($this->collUserGroupss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collGroupVictimss) {
                foreach ($this->collGroupVictimss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collVictimMailingss) {
                foreach ($this->collVictimMailingss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collGroupMailingss) {
                foreach ($this->collGroupMailingss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUsers) {
                foreach ($this->collUsers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collVictims) {
                foreach ($this->collVictims as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collMailings) {
                foreach ($this->collMailings as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collWebVisits = null;
        $this->collWebConversions = null;
        $this->collUserGroupss = null;
        $this->collGroupVictimss = null;
        $this->collVictimMailingss = null;
        $this->collGroupMailingss = null;
        $this->collUsers = null;
        $this->collVictims = null;
        $this->collMailings = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(GroupTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
