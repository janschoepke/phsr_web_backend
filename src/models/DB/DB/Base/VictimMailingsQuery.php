<?php

namespace DB\Base;

use \Exception;
use \PDO;
use DB\VictimMailings as ChildVictimMailings;
use DB\VictimMailingsQuery as ChildVictimMailingsQuery;
use DB\Map\VictimMailingsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'Victim_Mailings' table.
 *
 *
 *
 * @method     ChildVictimMailingsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildVictimMailingsQuery orderByVictimId($order = Criteria::ASC) Order by the victim_id column
 * @method     ChildVictimMailingsQuery orderByMailingId($order = Criteria::ASC) Order by the mailing_id column
 * @method     ChildVictimMailingsQuery orderByTimestamp($order = Criteria::ASC) Order by the timestamp column
 * @method     ChildVictimMailingsQuery orderByOpened($order = Criteria::ASC) Order by the opened column
 * @method     ChildVictimMailingsQuery orderByClicked($order = Criteria::ASC) Order by the clicked column
 * @method     ChildVictimMailingsQuery orderByCustomparam($order = Criteria::ASC) Order by the customParam column
 *
 * @method     ChildVictimMailingsQuery groupById() Group by the id column
 * @method     ChildVictimMailingsQuery groupByVictimId() Group by the victim_id column
 * @method     ChildVictimMailingsQuery groupByMailingId() Group by the mailing_id column
 * @method     ChildVictimMailingsQuery groupByTimestamp() Group by the timestamp column
 * @method     ChildVictimMailingsQuery groupByOpened() Group by the opened column
 * @method     ChildVictimMailingsQuery groupByClicked() Group by the clicked column
 * @method     ChildVictimMailingsQuery groupByCustomparam() Group by the customParam column
 *
 * @method     ChildVictimMailingsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildVictimMailingsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildVictimMailingsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildVictimMailingsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildVictimMailingsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildVictimMailingsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildVictimMailingsQuery leftJoinVictim($relationAlias = null) Adds a LEFT JOIN clause to the query using the Victim relation
 * @method     ChildVictimMailingsQuery rightJoinVictim($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Victim relation
 * @method     ChildVictimMailingsQuery innerJoinVictim($relationAlias = null) Adds a INNER JOIN clause to the query using the Victim relation
 *
 * @method     ChildVictimMailingsQuery joinWithVictim($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Victim relation
 *
 * @method     ChildVictimMailingsQuery leftJoinWithVictim() Adds a LEFT JOIN clause and with to the query using the Victim relation
 * @method     ChildVictimMailingsQuery rightJoinWithVictim() Adds a RIGHT JOIN clause and with to the query using the Victim relation
 * @method     ChildVictimMailingsQuery innerJoinWithVictim() Adds a INNER JOIN clause and with to the query using the Victim relation
 *
 * @method     ChildVictimMailingsQuery leftJoinMailing($relationAlias = null) Adds a LEFT JOIN clause to the query using the Mailing relation
 * @method     ChildVictimMailingsQuery rightJoinMailing($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Mailing relation
 * @method     ChildVictimMailingsQuery innerJoinMailing($relationAlias = null) Adds a INNER JOIN clause to the query using the Mailing relation
 *
 * @method     ChildVictimMailingsQuery joinWithMailing($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Mailing relation
 *
 * @method     ChildVictimMailingsQuery leftJoinWithMailing() Adds a LEFT JOIN clause and with to the query using the Mailing relation
 * @method     ChildVictimMailingsQuery rightJoinWithMailing() Adds a RIGHT JOIN clause and with to the query using the Mailing relation
 * @method     ChildVictimMailingsQuery innerJoinWithMailing() Adds a INNER JOIN clause and with to the query using the Mailing relation
 *
 * @method     \DB\VictimQuery|\DB\MailingQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildVictimMailings findOne(ConnectionInterface $con = null) Return the first ChildVictimMailings matching the query
 * @method     ChildVictimMailings findOneOrCreate(ConnectionInterface $con = null) Return the first ChildVictimMailings matching the query, or a new ChildVictimMailings object populated from the query conditions when no match is found
 *
 * @method     ChildVictimMailings findOneById(int $id) Return the first ChildVictimMailings filtered by the id column
 * @method     ChildVictimMailings findOneByVictimId(int $victim_id) Return the first ChildVictimMailings filtered by the victim_id column
 * @method     ChildVictimMailings findOneByMailingId(int $mailing_id) Return the first ChildVictimMailings filtered by the mailing_id column
 * @method     ChildVictimMailings findOneByTimestamp(string $timestamp) Return the first ChildVictimMailings filtered by the timestamp column
 * @method     ChildVictimMailings findOneByOpened(int $opened) Return the first ChildVictimMailings filtered by the opened column
 * @method     ChildVictimMailings findOneByClicked(int $clicked) Return the first ChildVictimMailings filtered by the clicked column
 * @method     ChildVictimMailings findOneByCustomparam(string $customParam) Return the first ChildVictimMailings filtered by the customParam column *

 * @method     ChildVictimMailings requirePk($key, ConnectionInterface $con = null) Return the ChildVictimMailings by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVictimMailings requireOne(ConnectionInterface $con = null) Return the first ChildVictimMailings matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildVictimMailings requireOneById(int $id) Return the first ChildVictimMailings filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVictimMailings requireOneByVictimId(int $victim_id) Return the first ChildVictimMailings filtered by the victim_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVictimMailings requireOneByMailingId(int $mailing_id) Return the first ChildVictimMailings filtered by the mailing_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVictimMailings requireOneByTimestamp(string $timestamp) Return the first ChildVictimMailings filtered by the timestamp column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVictimMailings requireOneByOpened(int $opened) Return the first ChildVictimMailings filtered by the opened column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVictimMailings requireOneByClicked(int $clicked) Return the first ChildVictimMailings filtered by the clicked column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVictimMailings requireOneByCustomparam(string $customParam) Return the first ChildVictimMailings filtered by the customParam column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildVictimMailings[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildVictimMailings objects based on current ModelCriteria
 * @method     ChildVictimMailings[]|ObjectCollection findById(int $id) Return ChildVictimMailings objects filtered by the id column
 * @method     ChildVictimMailings[]|ObjectCollection findByVictimId(int $victim_id) Return ChildVictimMailings objects filtered by the victim_id column
 * @method     ChildVictimMailings[]|ObjectCollection findByMailingId(int $mailing_id) Return ChildVictimMailings objects filtered by the mailing_id column
 * @method     ChildVictimMailings[]|ObjectCollection findByTimestamp(string $timestamp) Return ChildVictimMailings objects filtered by the timestamp column
 * @method     ChildVictimMailings[]|ObjectCollection findByOpened(int $opened) Return ChildVictimMailings objects filtered by the opened column
 * @method     ChildVictimMailings[]|ObjectCollection findByClicked(int $clicked) Return ChildVictimMailings objects filtered by the clicked column
 * @method     ChildVictimMailings[]|ObjectCollection findByCustomparam(string $customParam) Return ChildVictimMailings objects filtered by the customParam column
 * @method     ChildVictimMailings[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class VictimMailingsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \DB\Base\VictimMailingsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\DB\\VictimMailings', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildVictimMailingsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildVictimMailingsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildVictimMailingsQuery) {
            return $criteria;
        }
        $query = new ChildVictimMailingsQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildVictimMailings|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(VictimMailingsTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = VictimMailingsTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildVictimMailings A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, victim_id, mailing_id, timestamp, opened, clicked, customParam FROM Victim_Mailings WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildVictimMailings $obj */
            $obj = new ChildVictimMailings();
            $obj->hydrate($row);
            VictimMailingsTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildVictimMailings|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildVictimMailingsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(VictimMailingsTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildVictimMailingsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(VictimMailingsTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVictimMailingsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(VictimMailingsTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(VictimMailingsTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VictimMailingsTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the victim_id column
     *
     * Example usage:
     * <code>
     * $query->filterByVictimId(1234); // WHERE victim_id = 1234
     * $query->filterByVictimId(array(12, 34)); // WHERE victim_id IN (12, 34)
     * $query->filterByVictimId(array('min' => 12)); // WHERE victim_id > 12
     * </code>
     *
     * @see       filterByVictim()
     *
     * @param     mixed $victimId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVictimMailingsQuery The current query, for fluid interface
     */
    public function filterByVictimId($victimId = null, $comparison = null)
    {
        if (is_array($victimId)) {
            $useMinMax = false;
            if (isset($victimId['min'])) {
                $this->addUsingAlias(VictimMailingsTableMap::COL_VICTIM_ID, $victimId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($victimId['max'])) {
                $this->addUsingAlias(VictimMailingsTableMap::COL_VICTIM_ID, $victimId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VictimMailingsTableMap::COL_VICTIM_ID, $victimId, $comparison);
    }

    /**
     * Filter the query on the mailing_id column
     *
     * Example usage:
     * <code>
     * $query->filterByMailingId(1234); // WHERE mailing_id = 1234
     * $query->filterByMailingId(array(12, 34)); // WHERE mailing_id IN (12, 34)
     * $query->filterByMailingId(array('min' => 12)); // WHERE mailing_id > 12
     * </code>
     *
     * @see       filterByMailing()
     *
     * @param     mixed $mailingId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVictimMailingsQuery The current query, for fluid interface
     */
    public function filterByMailingId($mailingId = null, $comparison = null)
    {
        if (is_array($mailingId)) {
            $useMinMax = false;
            if (isset($mailingId['min'])) {
                $this->addUsingAlias(VictimMailingsTableMap::COL_MAILING_ID, $mailingId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($mailingId['max'])) {
                $this->addUsingAlias(VictimMailingsTableMap::COL_MAILING_ID, $mailingId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VictimMailingsTableMap::COL_MAILING_ID, $mailingId, $comparison);
    }

    /**
     * Filter the query on the timestamp column
     *
     * Example usage:
     * <code>
     * $query->filterByTimestamp('2011-03-14'); // WHERE timestamp = '2011-03-14'
     * $query->filterByTimestamp('now'); // WHERE timestamp = '2011-03-14'
     * $query->filterByTimestamp(array('max' => 'yesterday')); // WHERE timestamp > '2011-03-13'
     * </code>
     *
     * @param     mixed $timestamp The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVictimMailingsQuery The current query, for fluid interface
     */
    public function filterByTimestamp($timestamp = null, $comparison = null)
    {
        if (is_array($timestamp)) {
            $useMinMax = false;
            if (isset($timestamp['min'])) {
                $this->addUsingAlias(VictimMailingsTableMap::COL_TIMESTAMP, $timestamp['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($timestamp['max'])) {
                $this->addUsingAlias(VictimMailingsTableMap::COL_TIMESTAMP, $timestamp['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VictimMailingsTableMap::COL_TIMESTAMP, $timestamp, $comparison);
    }

    /**
     * Filter the query on the opened column
     *
     * Example usage:
     * <code>
     * $query->filterByOpened(1234); // WHERE opened = 1234
     * $query->filterByOpened(array(12, 34)); // WHERE opened IN (12, 34)
     * $query->filterByOpened(array('min' => 12)); // WHERE opened > 12
     * </code>
     *
     * @param     mixed $opened The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVictimMailingsQuery The current query, for fluid interface
     */
    public function filterByOpened($opened = null, $comparison = null)
    {
        if (is_array($opened)) {
            $useMinMax = false;
            if (isset($opened['min'])) {
                $this->addUsingAlias(VictimMailingsTableMap::COL_OPENED, $opened['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($opened['max'])) {
                $this->addUsingAlias(VictimMailingsTableMap::COL_OPENED, $opened['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VictimMailingsTableMap::COL_OPENED, $opened, $comparison);
    }

    /**
     * Filter the query on the clicked column
     *
     * Example usage:
     * <code>
     * $query->filterByClicked(1234); // WHERE clicked = 1234
     * $query->filterByClicked(array(12, 34)); // WHERE clicked IN (12, 34)
     * $query->filterByClicked(array('min' => 12)); // WHERE clicked > 12
     * </code>
     *
     * @param     mixed $clicked The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVictimMailingsQuery The current query, for fluid interface
     */
    public function filterByClicked($clicked = null, $comparison = null)
    {
        if (is_array($clicked)) {
            $useMinMax = false;
            if (isset($clicked['min'])) {
                $this->addUsingAlias(VictimMailingsTableMap::COL_CLICKED, $clicked['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($clicked['max'])) {
                $this->addUsingAlias(VictimMailingsTableMap::COL_CLICKED, $clicked['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VictimMailingsTableMap::COL_CLICKED, $clicked, $comparison);
    }

    /**
     * Filter the query on the customParam column
     *
     * Example usage:
     * <code>
     * $query->filterByCustomparam('fooValue');   // WHERE customParam = 'fooValue'
     * $query->filterByCustomparam('%fooValue%', Criteria::LIKE); // WHERE customParam LIKE '%fooValue%'
     * </code>
     *
     * @param     string $customparam The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVictimMailingsQuery The current query, for fluid interface
     */
    public function filterByCustomparam($customparam = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($customparam)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VictimMailingsTableMap::COL_CUSTOMPARAM, $customparam, $comparison);
    }

    /**
     * Filter the query by a related \DB\Victim object
     *
     * @param \DB\Victim|ObjectCollection $victim The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildVictimMailingsQuery The current query, for fluid interface
     */
    public function filterByVictim($victim, $comparison = null)
    {
        if ($victim instanceof \DB\Victim) {
            return $this
                ->addUsingAlias(VictimMailingsTableMap::COL_VICTIM_ID, $victim->getId(), $comparison);
        } elseif ($victim instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(VictimMailingsTableMap::COL_VICTIM_ID, $victim->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByVictim() only accepts arguments of type \DB\Victim or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Victim relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildVictimMailingsQuery The current query, for fluid interface
     */
    public function joinVictim($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Victim');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Victim');
        }

        return $this;
    }

    /**
     * Use the Victim relation Victim object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DB\VictimQuery A secondary query class using the current class as primary query
     */
    public function useVictimQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinVictim($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Victim', '\DB\VictimQuery');
    }

    /**
     * Filter the query by a related \DB\Mailing object
     *
     * @param \DB\Mailing|ObjectCollection $mailing The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildVictimMailingsQuery The current query, for fluid interface
     */
    public function filterByMailing($mailing, $comparison = null)
    {
        if ($mailing instanceof \DB\Mailing) {
            return $this
                ->addUsingAlias(VictimMailingsTableMap::COL_MAILING_ID, $mailing->getId(), $comparison);
        } elseif ($mailing instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(VictimMailingsTableMap::COL_MAILING_ID, $mailing->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByMailing() only accepts arguments of type \DB\Mailing or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Mailing relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildVictimMailingsQuery The current query, for fluid interface
     */
    public function joinMailing($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Mailing');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Mailing');
        }

        return $this;
    }

    /**
     * Use the Mailing relation Mailing object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DB\MailingQuery A secondary query class using the current class as primary query
     */
    public function useMailingQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinMailing($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Mailing', '\DB\MailingQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildVictimMailings $victimMailings Object to remove from the list of results
     *
     * @return $this|ChildVictimMailingsQuery The current query, for fluid interface
     */
    public function prune($victimMailings = null)
    {
        if ($victimMailings) {
            $this->addUsingAlias(VictimMailingsTableMap::COL_ID, $victimMailings->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the Victim_Mailings table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(VictimMailingsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            VictimMailingsTableMap::clearInstancePool();
            VictimMailingsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(VictimMailingsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(VictimMailingsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            VictimMailingsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            VictimMailingsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // VictimMailingsQuery
