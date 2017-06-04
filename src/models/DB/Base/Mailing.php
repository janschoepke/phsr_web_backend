<?php

namespace DB\Base;

use \Exception;
use \PDO;
use DB\Group as ChildGroup;
use DB\GroupMailings as ChildGroupMailings;
use DB\GroupMailingsQuery as ChildGroupMailingsQuery;
use DB\GroupQuery as ChildGroupQuery;
use DB\Mailing as ChildMailing;
use DB\MailingQuery as ChildMailingQuery;
use DB\User as ChildUser;
use DB\UserMailings as ChildUserMailings;
use DB\UserMailingsQuery as ChildUserMailingsQuery;
use DB\UserQuery as ChildUserQuery;
use DB\Victim as ChildVictim;
use DB\VictimMailings as ChildVictimMailings;
use DB\VictimMailingsQuery as ChildVictimMailingsQuery;
use DB\VictimQuery as ChildVictimQuery;
use DB\Map\GroupMailingsTableMap;
use DB\Map\MailingTableMap;
use DB\Map\UserMailingsTableMap;
use DB\Map\VictimMailingsTableMap;
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
 * Base class that represents a row from the 'Mailings' table.
 *
 *
 *
 * @package    propel.generator.DB.Base
 */
abstract class Mailing implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\DB\\Map\\MailingTableMap';


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
     * The value for the headline field.
     *
     * @var        string
     */
    protected $headline;

    /**
     * The value for the content field.
     *
     * @var        string
     */
    protected $content;

    /**
     * The value for the description field.
     *
     * @var        string
     */
    protected $description;

    /**
     * @var        ObjectCollection|ChildVictimMailings[] Collection to store aggregation of ChildVictimMailings objects.
     */
    protected $collVictimMailingss;
    protected $collVictimMailingssPartial;

    /**
     * @var        ObjectCollection|ChildUserMailings[] Collection to store aggregation of ChildUserMailings objects.
     */
    protected $collUserMailingss;
    protected $collUserMailingssPartial;

    /**
     * @var        ObjectCollection|ChildGroupMailings[] Collection to store aggregation of ChildGroupMailings objects.
     */
    protected $collGroupMailingss;
    protected $collGroupMailingssPartial;

    /**
     * @var        ObjectCollection|ChildVictim[] Cross Collection to store aggregation of ChildVictim objects.
     */
    protected $collVictims;

    /**
     * @var bool
     */
    protected $collVictimsPartial;

    /**
     * @var        ObjectCollection|ChildUser[] Cross Collection to store aggregation of ChildUser objects.
     */
    protected $collUsers;

    /**
     * @var bool
     */
    protected $collUsersPartial;

    /**
     * @var        ObjectCollection|ChildGroup[] Cross Collection to store aggregation of ChildGroup objects.
     */
    protected $collGroups;

    /**
     * @var bool
     */
    protected $collGroupsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildVictim[]
     */
    protected $victimsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildUser[]
     */
    protected $usersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildGroup[]
     */
    protected $groupsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildVictimMailings[]
     */
    protected $victimMailingssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildUserMailings[]
     */
    protected $userMailingssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildGroupMailings[]
     */
    protected $groupMailingssScheduledForDeletion = null;

    /**
     * Initializes internal state of DB\Base\Mailing object.
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
     * Compares this with another <code>Mailing</code> instance.  If
     * <code>obj</code> is an instance of <code>Mailing</code>, delegates to
     * <code>equals(Mailing)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Mailing The current object, for fluid interface
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
     * Get the [headline] column value.
     *
     * @return string
     */
    public function getHeadline()
    {
        return $this->headline;
    }

    /**
     * Get the [content] column value.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
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
     * @return $this|\DB\Mailing The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[MailingTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\DB\Mailing The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[MailingTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [headline] column.
     *
     * @param string $v new value
     * @return $this|\DB\Mailing The current object (for fluent API support)
     */
    public function setHeadline($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->headline !== $v) {
            $this->headline = $v;
            $this->modifiedColumns[MailingTableMap::COL_HEADLINE] = true;
        }

        return $this;
    } // setHeadline()

    /**
     * Set the value of [content] column.
     *
     * @param string $v new value
     * @return $this|\DB\Mailing The current object (for fluent API support)
     */
    public function setContent($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->content !== $v) {
            $this->content = $v;
            $this->modifiedColumns[MailingTableMap::COL_CONTENT] = true;
        }

        return $this;
    } // setContent()

    /**
     * Set the value of [description] column.
     *
     * @param string $v new value
     * @return $this|\DB\Mailing The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[MailingTableMap::COL_DESCRIPTION] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : MailingTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : MailingTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : MailingTableMap::translateFieldName('Headline', TableMap::TYPE_PHPNAME, $indexType)];
            $this->headline = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : MailingTableMap::translateFieldName('Content', TableMap::TYPE_PHPNAME, $indexType)];
            $this->content = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : MailingTableMap::translateFieldName('Description', TableMap::TYPE_PHPNAME, $indexType)];
            $this->description = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 5; // 5 = MailingTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\DB\\Mailing'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(MailingTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildMailingQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collVictimMailingss = null;

            $this->collUserMailingss = null;

            $this->collGroupMailingss = null;

            $this->collVictims = null;
            $this->collUsers = null;
            $this->collGroups = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Mailing::setDeleted()
     * @see Mailing::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(MailingTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildMailingQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(MailingTableMap::DATABASE_NAME);
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
                MailingTableMap::addInstanceToPool($this);
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

            if ($this->victimsScheduledForDeletion !== null) {
                if (!$this->victimsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->victimsScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \DB\VictimMailingsQuery::create()
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


            if ($this->usersScheduledForDeletion !== null) {
                if (!$this->usersScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->usersScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \DB\UserMailingsQuery::create()
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


            if ($this->groupsScheduledForDeletion !== null) {
                if (!$this->groupsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->groupsScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \DB\GroupMailingsQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->groupsScheduledForDeletion = null;
                }

            }

            if ($this->collGroups) {
                foreach ($this->collGroups as $group) {
                    if (!$group->isDeleted() && ($group->isNew() || $group->isModified())) {
                        $group->save($con);
                    }
                }
            }


            if ($this->victimMailingssScheduledForDeletion !== null) {
                if (!$this->victimMailingssScheduledForDeletion->isEmpty()) {
                    \DB\VictimMailingsQuery::create()
                        ->filterByPrimaryKeys($this->victimMailingssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
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

            if ($this->userMailingssScheduledForDeletion !== null) {
                if (!$this->userMailingssScheduledForDeletion->isEmpty()) {
                    \DB\UserMailingsQuery::create()
                        ->filterByPrimaryKeys($this->userMailingssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->userMailingssScheduledForDeletion = null;
                }
            }

            if ($this->collUserMailingss !== null) {
                foreach ($this->collUserMailingss as $referrerFK) {
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

        $this->modifiedColumns[MailingTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . MailingTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(MailingTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(MailingTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(MailingTableMap::COL_HEADLINE)) {
            $modifiedColumns[':p' . $index++]  = 'headline';
        }
        if ($this->isColumnModified(MailingTableMap::COL_CONTENT)) {
            $modifiedColumns[':p' . $index++]  = 'content';
        }
        if ($this->isColumnModified(MailingTableMap::COL_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = 'description';
        }

        $sql = sprintf(
            'INSERT INTO Mailings (%s) VALUES (%s)',
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
                    case 'headline':
                        $stmt->bindValue($identifier, $this->headline, PDO::PARAM_STR);
                        break;
                    case 'content':
                        $stmt->bindValue($identifier, $this->content, PDO::PARAM_STR);
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
        $pos = MailingTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getHeadline();
                break;
            case 3:
                return $this->getContent();
                break;
            case 4:
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

        if (isset($alreadyDumpedObjects['Mailing'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Mailing'][$this->hashCode()] = true;
        $keys = MailingTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getHeadline(),
            $keys[3] => $this->getContent(),
            $keys[4] => $this->getDescription(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
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
            if (null !== $this->collUserMailingss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'userMailingss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'User_Mailingss';
                        break;
                    default:
                        $key = 'UserMailingss';
                }

                $result[$key] = $this->collUserMailingss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\DB\Mailing
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = MailingTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\DB\Mailing
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
                $this->setHeadline($value);
                break;
            case 3:
                $this->setContent($value);
                break;
            case 4:
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
        $keys = MailingTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setHeadline($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setContent($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setDescription($arr[$keys[4]]);
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
     * @return $this|\DB\Mailing The current object, for fluid interface
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
        $criteria = new Criteria(MailingTableMap::DATABASE_NAME);

        if ($this->isColumnModified(MailingTableMap::COL_ID)) {
            $criteria->add(MailingTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(MailingTableMap::COL_NAME)) {
            $criteria->add(MailingTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(MailingTableMap::COL_HEADLINE)) {
            $criteria->add(MailingTableMap::COL_HEADLINE, $this->headline);
        }
        if ($this->isColumnModified(MailingTableMap::COL_CONTENT)) {
            $criteria->add(MailingTableMap::COL_CONTENT, $this->content);
        }
        if ($this->isColumnModified(MailingTableMap::COL_DESCRIPTION)) {
            $criteria->add(MailingTableMap::COL_DESCRIPTION, $this->description);
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
        $criteria = ChildMailingQuery::create();
        $criteria->add(MailingTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \DB\Mailing (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setHeadline($this->getHeadline());
        $copyObj->setContent($this->getContent());
        $copyObj->setDescription($this->getDescription());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getVictimMailingss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addVictimMailings($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getUserMailingss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addUserMailings($relObj->copy($deepCopy));
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
     * @return \DB\Mailing Clone of current object.
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
        if ('VictimMailings' == $relationName) {
            return $this->initVictimMailingss();
        }
        if ('UserMailings' == $relationName) {
            return $this->initUserMailingss();
        }
        if ('GroupMailings' == $relationName) {
            return $this->initGroupMailingss();
        }
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
     * If this ChildMailing is new, it will return
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
                    ->filterByMailing($this)
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
     * @return $this|ChildMailing The current object (for fluent API support)
     */
    public function setVictimMailingss(Collection $victimMailingss, ConnectionInterface $con = null)
    {
        /** @var ChildVictimMailings[] $victimMailingssToDelete */
        $victimMailingssToDelete = $this->getVictimMailingss(new Criteria(), $con)->diff($victimMailingss);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->victimMailingssScheduledForDeletion = clone $victimMailingssToDelete;

        foreach ($victimMailingssToDelete as $victimMailingsRemoved) {
            $victimMailingsRemoved->setMailing(null);
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
                ->filterByMailing($this)
                ->count($con);
        }

        return count($this->collVictimMailingss);
    }

    /**
     * Method called to associate a ChildVictimMailings object to this object
     * through the ChildVictimMailings foreign key attribute.
     *
     * @param  ChildVictimMailings $l ChildVictimMailings
     * @return $this|\DB\Mailing The current object (for fluent API support)
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
        $victimMailings->setMailing($this);
    }

    /**
     * @param  ChildVictimMailings $victimMailings The ChildVictimMailings object to remove.
     * @return $this|ChildMailing The current object (for fluent API support)
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
            $this->victimMailingssScheduledForDeletion[]= clone $victimMailings;
            $victimMailings->setMailing(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Mailing is new, it will return
     * an empty collection; or if this Mailing has previously
     * been saved, it will retrieve related VictimMailingss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Mailing.
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
     * Clears out the collUserMailingss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addUserMailingss()
     */
    public function clearUserMailingss()
    {
        $this->collUserMailingss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collUserMailingss collection loaded partially.
     */
    public function resetPartialUserMailingss($v = true)
    {
        $this->collUserMailingssPartial = $v;
    }

    /**
     * Initializes the collUserMailingss collection.
     *
     * By default this just sets the collUserMailingss collection to an empty array (like clearcollUserMailingss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUserMailingss($overrideExisting = true)
    {
        if (null !== $this->collUserMailingss && !$overrideExisting) {
            return;
        }

        $collectionClassName = UserMailingsTableMap::getTableMap()->getCollectionClassName();

        $this->collUserMailingss = new $collectionClassName;
        $this->collUserMailingss->setModel('\DB\UserMailings');
    }

    /**
     * Gets an array of ChildUserMailings objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildMailing is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildUserMailings[] List of ChildUserMailings objects
     * @throws PropelException
     */
    public function getUserMailingss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collUserMailingssPartial && !$this->isNew();
        if (null === $this->collUserMailingss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collUserMailingss) {
                // return empty collection
                $this->initUserMailingss();
            } else {
                $collUserMailingss = ChildUserMailingsQuery::create(null, $criteria)
                    ->filterByMailing($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collUserMailingssPartial && count($collUserMailingss)) {
                        $this->initUserMailingss(false);

                        foreach ($collUserMailingss as $obj) {
                            if (false == $this->collUserMailingss->contains($obj)) {
                                $this->collUserMailingss->append($obj);
                            }
                        }

                        $this->collUserMailingssPartial = true;
                    }

                    return $collUserMailingss;
                }

                if ($partial && $this->collUserMailingss) {
                    foreach ($this->collUserMailingss as $obj) {
                        if ($obj->isNew()) {
                            $collUserMailingss[] = $obj;
                        }
                    }
                }

                $this->collUserMailingss = $collUserMailingss;
                $this->collUserMailingssPartial = false;
            }
        }

        return $this->collUserMailingss;
    }

    /**
     * Sets a collection of ChildUserMailings objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $userMailingss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildMailing The current object (for fluent API support)
     */
    public function setUserMailingss(Collection $userMailingss, ConnectionInterface $con = null)
    {
        /** @var ChildUserMailings[] $userMailingssToDelete */
        $userMailingssToDelete = $this->getUserMailingss(new Criteria(), $con)->diff($userMailingss);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->userMailingssScheduledForDeletion = clone $userMailingssToDelete;

        foreach ($userMailingssToDelete as $userMailingsRemoved) {
            $userMailingsRemoved->setMailing(null);
        }

        $this->collUserMailingss = null;
        foreach ($userMailingss as $userMailings) {
            $this->addUserMailings($userMailings);
        }

        $this->collUserMailingss = $userMailingss;
        $this->collUserMailingssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related UserMailings objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related UserMailings objects.
     * @throws PropelException
     */
    public function countUserMailingss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collUserMailingssPartial && !$this->isNew();
        if (null === $this->collUserMailingss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUserMailingss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getUserMailingss());
            }

            $query = ChildUserMailingsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByMailing($this)
                ->count($con);
        }

        return count($this->collUserMailingss);
    }

    /**
     * Method called to associate a ChildUserMailings object to this object
     * through the ChildUserMailings foreign key attribute.
     *
     * @param  ChildUserMailings $l ChildUserMailings
     * @return $this|\DB\Mailing The current object (for fluent API support)
     */
    public function addUserMailings(ChildUserMailings $l)
    {
        if ($this->collUserMailingss === null) {
            $this->initUserMailingss();
            $this->collUserMailingssPartial = true;
        }

        if (!$this->collUserMailingss->contains($l)) {
            $this->doAddUserMailings($l);

            if ($this->userMailingssScheduledForDeletion and $this->userMailingssScheduledForDeletion->contains($l)) {
                $this->userMailingssScheduledForDeletion->remove($this->userMailingssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildUserMailings $userMailings The ChildUserMailings object to add.
     */
    protected function doAddUserMailings(ChildUserMailings $userMailings)
    {
        $this->collUserMailingss[]= $userMailings;
        $userMailings->setMailing($this);
    }

    /**
     * @param  ChildUserMailings $userMailings The ChildUserMailings object to remove.
     * @return $this|ChildMailing The current object (for fluent API support)
     */
    public function removeUserMailings(ChildUserMailings $userMailings)
    {
        if ($this->getUserMailingss()->contains($userMailings)) {
            $pos = $this->collUserMailingss->search($userMailings);
            $this->collUserMailingss->remove($pos);
            if (null === $this->userMailingssScheduledForDeletion) {
                $this->userMailingssScheduledForDeletion = clone $this->collUserMailingss;
                $this->userMailingssScheduledForDeletion->clear();
            }
            $this->userMailingssScheduledForDeletion[]= clone $userMailings;
            $userMailings->setMailing(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Mailing is new, it will return
     * an empty collection; or if this Mailing has previously
     * been saved, it will retrieve related UserMailingss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Mailing.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildUserMailings[] List of ChildUserMailings objects
     */
    public function getUserMailingssJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildUserMailingsQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getUserMailingss($query, $con);
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
     * If this ChildMailing is new, it will return
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
                    ->filterByMailing($this)
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
     * @return $this|ChildMailing The current object (for fluent API support)
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
            $groupMailingsRemoved->setMailing(null);
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
                ->filterByMailing($this)
                ->count($con);
        }

        return count($this->collGroupMailingss);
    }

    /**
     * Method called to associate a ChildGroupMailings object to this object
     * through the ChildGroupMailings foreign key attribute.
     *
     * @param  ChildGroupMailings $l ChildGroupMailings
     * @return $this|\DB\Mailing The current object (for fluent API support)
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
        $groupMailings->setMailing($this);
    }

    /**
     * @param  ChildGroupMailings $groupMailings The ChildGroupMailings object to remove.
     * @return $this|ChildMailing The current object (for fluent API support)
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
            $groupMailings->setMailing(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Mailing is new, it will return
     * an empty collection; or if this Mailing has previously
     * been saved, it will retrieve related GroupMailingss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Mailing.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGroupMailings[] List of ChildGroupMailings objects
     */
    public function getGroupMailingssJoinGroup(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGroupMailingsQuery::create(null, $criteria);
        $query->joinWith('Group', $joinBehavior);

        return $this->getGroupMailingss($query, $con);
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
        $collectionClassName = VictimMailingsTableMap::getTableMap()->getCollectionClassName();

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
     * to the current object by way of the Victim_Mailings cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildMailing is new, it will return
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
                    ->filterByMailing($this);
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
     * to the current object by way of the Victim_Mailings cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $victims A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildMailing The current object (for fluent API support)
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
     * to the current object by way of the Victim_Mailings cross-reference table.
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
                    ->filterByMailing($this)
                    ->count($con);
            }
        } else {
            return count($this->collVictims);
        }
    }

    /**
     * Associate a ChildVictim to this object
     * through the Victim_Mailings cross reference table.
     *
     * @param ChildVictim $victim
     * @return ChildMailing The current object (for fluent API support)
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
        $victimMailings = new ChildVictimMailings();

        $victimMailings->setVictim($victim);

        $victimMailings->setMailing($this);

        $this->addVictimMailings($victimMailings);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$victim->isMailingsLoaded()) {
            $victim->initMailings();
            $victim->getMailings()->push($this);
        } elseif (!$victim->getMailings()->contains($this)) {
            $victim->getMailings()->push($this);
        }

    }

    /**
     * Remove victim of this object
     * through the Victim_Mailings cross reference table.
     *
     * @param ChildVictim $victim
     * @return ChildMailing The current object (for fluent API support)
     */
    public function removeVictim(ChildVictim $victim)
    {
        if ($this->getVictims()->contains($victim)) {
            $victimMailings = new ChildVictimMailings();
            $victimMailings->setVictim($victim);
            if ($victim->isMailingsLoaded()) {
                //remove the back reference if available
                $victim->getMailings()->removeObject($this);
            }

            $victimMailings->setMailing($this);
            $this->removeVictimMailings(clone $victimMailings);
            $victimMailings->clear();

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
        $collectionClassName = UserMailingsTableMap::getTableMap()->getCollectionClassName();

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
     * to the current object by way of the User_Mailings cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildMailing is new, it will return
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
                    ->filterByMailing($this);
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
     * to the current object by way of the User_Mailings cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $users A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildMailing The current object (for fluent API support)
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
     * to the current object by way of the User_Mailings cross-reference table.
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
                    ->filterByMailing($this)
                    ->count($con);
            }
        } else {
            return count($this->collUsers);
        }
    }

    /**
     * Associate a ChildUser to this object
     * through the User_Mailings cross reference table.
     *
     * @param ChildUser $user
     * @return ChildMailing The current object (for fluent API support)
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
        $userMailings = new ChildUserMailings();

        $userMailings->setUser($user);

        $userMailings->setMailing($this);

        $this->addUserMailings($userMailings);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$user->isMailingsLoaded()) {
            $user->initMailings();
            $user->getMailings()->push($this);
        } elseif (!$user->getMailings()->contains($this)) {
            $user->getMailings()->push($this);
        }

    }

    /**
     * Remove user of this object
     * through the User_Mailings cross reference table.
     *
     * @param ChildUser $user
     * @return ChildMailing The current object (for fluent API support)
     */
    public function removeUser(ChildUser $user)
    {
        if ($this->getUsers()->contains($user)) {
            $userMailings = new ChildUserMailings();
            $userMailings->setUser($user);
            if ($user->isMailingsLoaded()) {
                //remove the back reference if available
                $user->getMailings()->removeObject($this);
            }

            $userMailings->setMailing($this);
            $this->removeUserMailings(clone $userMailings);
            $userMailings->clear();

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
     * Clears out the collGroups collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addGroups()
     */
    public function clearGroups()
    {
        $this->collGroups = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collGroups crossRef collection.
     *
     * By default this just sets the collGroups collection to an empty collection (like clearGroups());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initGroups()
    {
        $collectionClassName = GroupMailingsTableMap::getTableMap()->getCollectionClassName();

        $this->collGroups = new $collectionClassName;
        $this->collGroupsPartial = true;
        $this->collGroups->setModel('\DB\Group');
    }

    /**
     * Checks if the collGroups collection is loaded.
     *
     * @return bool
     */
    public function isGroupsLoaded()
    {
        return null !== $this->collGroups;
    }

    /**
     * Gets a collection of ChildGroup objects related by a many-to-many relationship
     * to the current object by way of the Group_Mailings cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildMailing is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildGroup[] List of ChildGroup objects
     */
    public function getGroups(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collGroupsPartial && !$this->isNew();
        if (null === $this->collGroups || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collGroups) {
                    $this->initGroups();
                }
            } else {

                $query = ChildGroupQuery::create(null, $criteria)
                    ->filterByMailing($this);
                $collGroups = $query->find($con);
                if (null !== $criteria) {
                    return $collGroups;
                }

                if ($partial && $this->collGroups) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collGroups as $obj) {
                        if (!$collGroups->contains($obj)) {
                            $collGroups[] = $obj;
                        }
                    }
                }

                $this->collGroups = $collGroups;
                $this->collGroupsPartial = false;
            }
        }

        return $this->collGroups;
    }

    /**
     * Sets a collection of Group objects related by a many-to-many relationship
     * to the current object by way of the Group_Mailings cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $groups A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildMailing The current object (for fluent API support)
     */
    public function setGroups(Collection $groups, ConnectionInterface $con = null)
    {
        $this->clearGroups();
        $currentGroups = $this->getGroups();

        $groupsScheduledForDeletion = $currentGroups->diff($groups);

        foreach ($groupsScheduledForDeletion as $toDelete) {
            $this->removeGroup($toDelete);
        }

        foreach ($groups as $group) {
            if (!$currentGroups->contains($group)) {
                $this->doAddGroup($group);
            }
        }

        $this->collGroupsPartial = false;
        $this->collGroups = $groups;

        return $this;
    }

    /**
     * Gets the number of Group objects related by a many-to-many relationship
     * to the current object by way of the Group_Mailings cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Group objects
     */
    public function countGroups(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collGroupsPartial && !$this->isNew();
        if (null === $this->collGroups || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collGroups) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getGroups());
                }

                $query = ChildGroupQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByMailing($this)
                    ->count($con);
            }
        } else {
            return count($this->collGroups);
        }
    }

    /**
     * Associate a ChildGroup to this object
     * through the Group_Mailings cross reference table.
     *
     * @param ChildGroup $group
     * @return ChildMailing The current object (for fluent API support)
     */
    public function addGroup(ChildGroup $group)
    {
        if ($this->collGroups === null) {
            $this->initGroups();
        }

        if (!$this->getGroups()->contains($group)) {
            // only add it if the **same** object is not already associated
            $this->collGroups->push($group);
            $this->doAddGroup($group);
        }

        return $this;
    }

    /**
     *
     * @param ChildGroup $group
     */
    protected function doAddGroup(ChildGroup $group)
    {
        $groupMailings = new ChildGroupMailings();

        $groupMailings->setGroup($group);

        $groupMailings->setMailing($this);

        $this->addGroupMailings($groupMailings);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$group->isMailingsLoaded()) {
            $group->initMailings();
            $group->getMailings()->push($this);
        } elseif (!$group->getMailings()->contains($this)) {
            $group->getMailings()->push($this);
        }

    }

    /**
     * Remove group of this object
     * through the Group_Mailings cross reference table.
     *
     * @param ChildGroup $group
     * @return ChildMailing The current object (for fluent API support)
     */
    public function removeGroup(ChildGroup $group)
    {
        if ($this->getGroups()->contains($group)) {
            $groupMailings = new ChildGroupMailings();
            $groupMailings->setGroup($group);
            if ($group->isMailingsLoaded()) {
                //remove the back reference if available
                $group->getMailings()->removeObject($this);
            }

            $groupMailings->setMailing($this);
            $this->removeGroupMailings(clone $groupMailings);
            $groupMailings->clear();

            $this->collGroups->remove($this->collGroups->search($group));

            if (null === $this->groupsScheduledForDeletion) {
                $this->groupsScheduledForDeletion = clone $this->collGroups;
                $this->groupsScheduledForDeletion->clear();
            }

            $this->groupsScheduledForDeletion->push($group);
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
        $this->headline = null;
        $this->content = null;
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
            if ($this->collVictimMailingss) {
                foreach ($this->collVictimMailingss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUserMailingss) {
                foreach ($this->collUserMailingss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collGroupMailingss) {
                foreach ($this->collGroupMailingss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collVictims) {
                foreach ($this->collVictims as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUsers) {
                foreach ($this->collUsers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collGroups) {
                foreach ($this->collGroups as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collVictimMailingss = null;
        $this->collUserMailingss = null;
        $this->collGroupMailingss = null;
        $this->collVictims = null;
        $this->collUsers = null;
        $this->collGroups = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(MailingTableMap::DEFAULT_STRING_FORMAT);
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
