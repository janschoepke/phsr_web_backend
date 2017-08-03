<?php

namespace DB\Base;

use \Exception;
use \PDO;
use DB\WebVisit as ChildWebVisit;
use DB\WebVisitQuery as ChildWebVisitQuery;
use DB\Map\WebVisitTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'WebVisits' table.
 *
 *
 *
 * @method     ChildWebVisitQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildWebVisitQuery orderByMailingId($order = Criteria::ASC) Order by the mailing_id column
 * @method     ChildWebVisitQuery orderByOs($order = Criteria::ASC) Order by the os column
 * @method     ChildWebVisitQuery orderByTimestamp($order = Criteria::ASC) Order by the timestamp column
 * @method     ChildWebVisitQuery orderByUrl($order = Criteria::ASC) Order by the url column
 * @method     ChildWebVisitQuery orderByVictimId($order = Criteria::ASC) Order by the victim_id column
 * @method     ChildWebVisitQuery orderByUnknownId($order = Criteria::ASC) Order by the unknown_id column
 * @method     ChildWebVisitQuery orderByBrowser($order = Criteria::ASC) Order by the browser column
 * @method     ChildWebVisitQuery orderByIp($order = Criteria::ASC) Order by the ip column
 *
 * @method     ChildWebVisitQuery groupById() Group by the id column
 * @method     ChildWebVisitQuery groupByMailingId() Group by the mailing_id column
 * @method     ChildWebVisitQuery groupByOs() Group by the os column
 * @method     ChildWebVisitQuery groupByTimestamp() Group by the timestamp column
 * @method     ChildWebVisitQuery groupByUrl() Group by the url column
 * @method     ChildWebVisitQuery groupByVictimId() Group by the victim_id column
 * @method     ChildWebVisitQuery groupByUnknownId() Group by the unknown_id column
 * @method     ChildWebVisitQuery groupByBrowser() Group by the browser column
 * @method     ChildWebVisitQuery groupByIp() Group by the ip column
 *
 * @method     ChildWebVisitQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildWebVisitQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildWebVisitQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildWebVisitQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildWebVisitQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildWebVisitQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildWebVisitQuery leftJoinMailing($relationAlias = null) Adds a LEFT JOIN clause to the query using the Mailing relation
 * @method     ChildWebVisitQuery rightJoinMailing($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Mailing relation
 * @method     ChildWebVisitQuery innerJoinMailing($relationAlias = null) Adds a INNER JOIN clause to the query using the Mailing relation
 *
 * @method     ChildWebVisitQuery joinWithMailing($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Mailing relation
 *
 * @method     ChildWebVisitQuery leftJoinWithMailing() Adds a LEFT JOIN clause and with to the query using the Mailing relation
 * @method     ChildWebVisitQuery rightJoinWithMailing() Adds a RIGHT JOIN clause and with to the query using the Mailing relation
 * @method     ChildWebVisitQuery innerJoinWithMailing() Adds a INNER JOIN clause and with to the query using the Mailing relation
 *
 * @method     ChildWebVisitQuery leftJoinVictim($relationAlias = null) Adds a LEFT JOIN clause to the query using the Victim relation
 * @method     ChildWebVisitQuery rightJoinVictim($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Victim relation
 * @method     ChildWebVisitQuery innerJoinVictim($relationAlias = null) Adds a INNER JOIN clause to the query using the Victim relation
 *
 * @method     ChildWebVisitQuery joinWithVictim($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Victim relation
 *
 * @method     ChildWebVisitQuery leftJoinWithVictim() Adds a LEFT JOIN clause and with to the query using the Victim relation
 * @method     ChildWebVisitQuery rightJoinWithVictim() Adds a RIGHT JOIN clause and with to the query using the Victim relation
 * @method     ChildWebVisitQuery innerJoinWithVictim() Adds a INNER JOIN clause and with to the query using the Victim relation
 *
 * @method     \DB\MailingQuery|\DB\VictimQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildWebVisit findOne(ConnectionInterface $con = null) Return the first ChildWebVisit matching the query
 * @method     ChildWebVisit findOneOrCreate(ConnectionInterface $con = null) Return the first ChildWebVisit matching the query, or a new ChildWebVisit object populated from the query conditions when no match is found
 *
 * @method     ChildWebVisit findOneById(int $id) Return the first ChildWebVisit filtered by the id column
 * @method     ChildWebVisit findOneByMailingId(int $mailing_id) Return the first ChildWebVisit filtered by the mailing_id column
 * @method     ChildWebVisit findOneByOs(string $os) Return the first ChildWebVisit filtered by the os column
 * @method     ChildWebVisit findOneByTimestamp(string $timestamp) Return the first ChildWebVisit filtered by the timestamp column
 * @method     ChildWebVisit findOneByUrl(string $url) Return the first ChildWebVisit filtered by the url column
 * @method     ChildWebVisit findOneByVictimId(int $victim_id) Return the first ChildWebVisit filtered by the victim_id column
 * @method     ChildWebVisit findOneByUnknownId(string $unknown_id) Return the first ChildWebVisit filtered by the unknown_id column
 * @method     ChildWebVisit findOneByBrowser(string $browser) Return the first ChildWebVisit filtered by the browser column
 * @method     ChildWebVisit findOneByIp(string $ip) Return the first ChildWebVisit filtered by the ip column *

 * @method     ChildWebVisit requirePk($key, ConnectionInterface $con = null) Return the ChildWebVisit by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWebVisit requireOne(ConnectionInterface $con = null) Return the first ChildWebVisit matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildWebVisit requireOneById(int $id) Return the first ChildWebVisit filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWebVisit requireOneByMailingId(int $mailing_id) Return the first ChildWebVisit filtered by the mailing_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWebVisit requireOneByOs(string $os) Return the first ChildWebVisit filtered by the os column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWebVisit requireOneByTimestamp(string $timestamp) Return the first ChildWebVisit filtered by the timestamp column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWebVisit requireOneByUrl(string $url) Return the first ChildWebVisit filtered by the url column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWebVisit requireOneByVictimId(int $victim_id) Return the first ChildWebVisit filtered by the victim_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWebVisit requireOneByUnknownId(string $unknown_id) Return the first ChildWebVisit filtered by the unknown_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWebVisit requireOneByBrowser(string $browser) Return the first ChildWebVisit filtered by the browser column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWebVisit requireOneByIp(string $ip) Return the first ChildWebVisit filtered by the ip column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildWebVisit[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildWebVisit objects based on current ModelCriteria
 * @method     ChildWebVisit[]|ObjectCollection findById(int $id) Return ChildWebVisit objects filtered by the id column
 * @method     ChildWebVisit[]|ObjectCollection findByMailingId(int $mailing_id) Return ChildWebVisit objects filtered by the mailing_id column
 * @method     ChildWebVisit[]|ObjectCollection findByOs(string $os) Return ChildWebVisit objects filtered by the os column
 * @method     ChildWebVisit[]|ObjectCollection findByTimestamp(string $timestamp) Return ChildWebVisit objects filtered by the timestamp column
 * @method     ChildWebVisit[]|ObjectCollection findByUrl(string $url) Return ChildWebVisit objects filtered by the url column
 * @method     ChildWebVisit[]|ObjectCollection findByVictimId(int $victim_id) Return ChildWebVisit objects filtered by the victim_id column
 * @method     ChildWebVisit[]|ObjectCollection findByUnknownId(string $unknown_id) Return ChildWebVisit objects filtered by the unknown_id column
 * @method     ChildWebVisit[]|ObjectCollection findByBrowser(string $browser) Return ChildWebVisit objects filtered by the browser column
 * @method     ChildWebVisit[]|ObjectCollection findByIp(string $ip) Return ChildWebVisit objects filtered by the ip column
 * @method     ChildWebVisit[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class WebVisitQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \DB\Base\WebVisitQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\DB\\WebVisit', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildWebVisitQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildWebVisitQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildWebVisitQuery) {
            return $criteria;
        }
        $query = new ChildWebVisitQuery();
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
     * @return ChildWebVisit|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(WebVisitTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = WebVisitTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildWebVisit A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, mailing_id, os, timestamp, url, victim_id, unknown_id, browser, ip FROM WebVisits WHERE id = :p0';
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
            /** @var ChildWebVisit $obj */
            $obj = new ChildWebVisit();
            $obj->hydrate($row);
            WebVisitTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildWebVisit|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildWebVisitQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(WebVisitTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildWebVisitQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(WebVisitTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildWebVisitQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(WebVisitTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(WebVisitTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WebVisitTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildWebVisitQuery The current query, for fluid interface
     */
    public function filterByMailingId($mailingId = null, $comparison = null)
    {
        if (is_array($mailingId)) {
            $useMinMax = false;
            if (isset($mailingId['min'])) {
                $this->addUsingAlias(WebVisitTableMap::COL_MAILING_ID, $mailingId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($mailingId['max'])) {
                $this->addUsingAlias(WebVisitTableMap::COL_MAILING_ID, $mailingId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WebVisitTableMap::COL_MAILING_ID, $mailingId, $comparison);
    }

    /**
     * Filter the query on the os column
     *
     * Example usage:
     * <code>
     * $query->filterByOs('fooValue');   // WHERE os = 'fooValue'
     * $query->filterByOs('%fooValue%', Criteria::LIKE); // WHERE os LIKE '%fooValue%'
     * </code>
     *
     * @param     string $os The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWebVisitQuery The current query, for fluid interface
     */
    public function filterByOs($os = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($os)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WebVisitTableMap::COL_OS, $os, $comparison);
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
     * @return $this|ChildWebVisitQuery The current query, for fluid interface
     */
    public function filterByTimestamp($timestamp = null, $comparison = null)
    {
        if (is_array($timestamp)) {
            $useMinMax = false;
            if (isset($timestamp['min'])) {
                $this->addUsingAlias(WebVisitTableMap::COL_TIMESTAMP, $timestamp['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($timestamp['max'])) {
                $this->addUsingAlias(WebVisitTableMap::COL_TIMESTAMP, $timestamp['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WebVisitTableMap::COL_TIMESTAMP, $timestamp, $comparison);
    }

    /**
     * Filter the query on the url column
     *
     * Example usage:
     * <code>
     * $query->filterByUrl('fooValue');   // WHERE url = 'fooValue'
     * $query->filterByUrl('%fooValue%', Criteria::LIKE); // WHERE url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $url The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWebVisitQuery The current query, for fluid interface
     */
    public function filterByUrl($url = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($url)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WebVisitTableMap::COL_URL, $url, $comparison);
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
     * @return $this|ChildWebVisitQuery The current query, for fluid interface
     */
    public function filterByVictimId($victimId = null, $comparison = null)
    {
        if (is_array($victimId)) {
            $useMinMax = false;
            if (isset($victimId['min'])) {
                $this->addUsingAlias(WebVisitTableMap::COL_VICTIM_ID, $victimId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($victimId['max'])) {
                $this->addUsingAlias(WebVisitTableMap::COL_VICTIM_ID, $victimId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WebVisitTableMap::COL_VICTIM_ID, $victimId, $comparison);
    }

    /**
     * Filter the query on the unknown_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUnknownId('fooValue');   // WHERE unknown_id = 'fooValue'
     * $query->filterByUnknownId('%fooValue%', Criteria::LIKE); // WHERE unknown_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $unknownId The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWebVisitQuery The current query, for fluid interface
     */
    public function filterByUnknownId($unknownId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($unknownId)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WebVisitTableMap::COL_UNKNOWN_ID, $unknownId, $comparison);
    }

    /**
     * Filter the query on the browser column
     *
     * Example usage:
     * <code>
     * $query->filterByBrowser('fooValue');   // WHERE browser = 'fooValue'
     * $query->filterByBrowser('%fooValue%', Criteria::LIKE); // WHERE browser LIKE '%fooValue%'
     * </code>
     *
     * @param     string $browser The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWebVisitQuery The current query, for fluid interface
     */
    public function filterByBrowser($browser = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($browser)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WebVisitTableMap::COL_BROWSER, $browser, $comparison);
    }

    /**
     * Filter the query on the ip column
     *
     * Example usage:
     * <code>
     * $query->filterByIp('fooValue');   // WHERE ip = 'fooValue'
     * $query->filterByIp('%fooValue%', Criteria::LIKE); // WHERE ip LIKE '%fooValue%'
     * </code>
     *
     * @param     string $ip The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWebVisitQuery The current query, for fluid interface
     */
    public function filterByIp($ip = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ip)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WebVisitTableMap::COL_IP, $ip, $comparison);
    }

    /**
     * Filter the query by a related \DB\Mailing object
     *
     * @param \DB\Mailing|ObjectCollection $mailing The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildWebVisitQuery The current query, for fluid interface
     */
    public function filterByMailing($mailing, $comparison = null)
    {
        if ($mailing instanceof \DB\Mailing) {
            return $this
                ->addUsingAlias(WebVisitTableMap::COL_MAILING_ID, $mailing->getId(), $comparison);
        } elseif ($mailing instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(WebVisitTableMap::COL_MAILING_ID, $mailing->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildWebVisitQuery The current query, for fluid interface
     */
    public function joinMailing($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useMailingQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMailing($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Mailing', '\DB\MailingQuery');
    }

    /**
     * Filter the query by a related \DB\Victim object
     *
     * @param \DB\Victim|ObjectCollection $victim The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildWebVisitQuery The current query, for fluid interface
     */
    public function filterByVictim($victim, $comparison = null)
    {
        if ($victim instanceof \DB\Victim) {
            return $this
                ->addUsingAlias(WebVisitTableMap::COL_VICTIM_ID, $victim->getId(), $comparison);
        } elseif ($victim instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(WebVisitTableMap::COL_VICTIM_ID, $victim->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildWebVisitQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildWebVisit $webVisit Object to remove from the list of results
     *
     * @return $this|ChildWebVisitQuery The current query, for fluid interface
     */
    public function prune($webVisit = null)
    {
        if ($webVisit) {
            $this->addUsingAlias(WebVisitTableMap::COL_ID, $webVisit->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the WebVisits table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(WebVisitTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            WebVisitTableMap::clearInstancePool();
            WebVisitTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(WebVisitTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(WebVisitTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            WebVisitTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            WebVisitTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // WebVisitQuery
