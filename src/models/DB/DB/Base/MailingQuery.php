<?php

namespace DB\Base;

use \Exception;
use \PDO;
use DB\Mailing as ChildMailing;
use DB\MailingQuery as ChildMailingQuery;
use DB\Map\MailingTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'Mailings' table.
 *
 *
 *
 * @method     ChildMailingQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildMailingQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildMailingQuery orderByHeadline($order = Criteria::ASC) Order by the headline column
 * @method     ChildMailingQuery orderByContent($order = Criteria::ASC) Order by the content column
 * @method     ChildMailingQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildMailingQuery orderByFromemail($order = Criteria::ASC) Order by the fromEmail column
 * @method     ChildMailingQuery orderByFromname($order = Criteria::ASC) Order by the fromName column
 * @method     ChildMailingQuery orderByTracking($order = Criteria::ASC) Order by the tracking column
 * @method     ChildMailingQuery orderByIssmtp($order = Criteria::ASC) Order by the isSmtp column
 * @method     ChildMailingQuery orderBySmtphost($order = Criteria::ASC) Order by the smtpHost column
 * @method     ChildMailingQuery orderBySmtpuser($order = Criteria::ASC) Order by the smtpUser column
 * @method     ChildMailingQuery orderBySmtppassword($order = Criteria::ASC) Order by the smtpPassword column
 * @method     ChildMailingQuery orderBySmtpsecure($order = Criteria::ASC) Order by the smtpSecure column
 * @method     ChildMailingQuery orderBySmtpport($order = Criteria::ASC) Order by the smtpPort column
 *
 * @method     ChildMailingQuery groupById() Group by the id column
 * @method     ChildMailingQuery groupByName() Group by the name column
 * @method     ChildMailingQuery groupByHeadline() Group by the headline column
 * @method     ChildMailingQuery groupByContent() Group by the content column
 * @method     ChildMailingQuery groupByDescription() Group by the description column
 * @method     ChildMailingQuery groupByFromemail() Group by the fromEmail column
 * @method     ChildMailingQuery groupByFromname() Group by the fromName column
 * @method     ChildMailingQuery groupByTracking() Group by the tracking column
 * @method     ChildMailingQuery groupByIssmtp() Group by the isSmtp column
 * @method     ChildMailingQuery groupBySmtphost() Group by the smtpHost column
 * @method     ChildMailingQuery groupBySmtpuser() Group by the smtpUser column
 * @method     ChildMailingQuery groupBySmtppassword() Group by the smtpPassword column
 * @method     ChildMailingQuery groupBySmtpsecure() Group by the smtpSecure column
 * @method     ChildMailingQuery groupBySmtpport() Group by the smtpPort column
 *
 * @method     ChildMailingQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMailingQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMailingQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMailingQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildMailingQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildMailingQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildMailingQuery leftJoinWebVisit($relationAlias = null) Adds a LEFT JOIN clause to the query using the WebVisit relation
 * @method     ChildMailingQuery rightJoinWebVisit($relationAlias = null) Adds a RIGHT JOIN clause to the query using the WebVisit relation
 * @method     ChildMailingQuery innerJoinWebVisit($relationAlias = null) Adds a INNER JOIN clause to the query using the WebVisit relation
 *
 * @method     ChildMailingQuery joinWithWebVisit($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the WebVisit relation
 *
 * @method     ChildMailingQuery leftJoinWithWebVisit() Adds a LEFT JOIN clause and with to the query using the WebVisit relation
 * @method     ChildMailingQuery rightJoinWithWebVisit() Adds a RIGHT JOIN clause and with to the query using the WebVisit relation
 * @method     ChildMailingQuery innerJoinWithWebVisit() Adds a INNER JOIN clause and with to the query using the WebVisit relation
 *
 * @method     ChildMailingQuery leftJoinWebConversion($relationAlias = null) Adds a LEFT JOIN clause to the query using the WebConversion relation
 * @method     ChildMailingQuery rightJoinWebConversion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the WebConversion relation
 * @method     ChildMailingQuery innerJoinWebConversion($relationAlias = null) Adds a INNER JOIN clause to the query using the WebConversion relation
 *
 * @method     ChildMailingQuery joinWithWebConversion($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the WebConversion relation
 *
 * @method     ChildMailingQuery leftJoinWithWebConversion() Adds a LEFT JOIN clause and with to the query using the WebConversion relation
 * @method     ChildMailingQuery rightJoinWithWebConversion() Adds a RIGHT JOIN clause and with to the query using the WebConversion relation
 * @method     ChildMailingQuery innerJoinWithWebConversion() Adds a INNER JOIN clause and with to the query using the WebConversion relation
 *
 * @method     ChildMailingQuery leftJoinVictimMailings($relationAlias = null) Adds a LEFT JOIN clause to the query using the VictimMailings relation
 * @method     ChildMailingQuery rightJoinVictimMailings($relationAlias = null) Adds a RIGHT JOIN clause to the query using the VictimMailings relation
 * @method     ChildMailingQuery innerJoinVictimMailings($relationAlias = null) Adds a INNER JOIN clause to the query using the VictimMailings relation
 *
 * @method     ChildMailingQuery joinWithVictimMailings($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the VictimMailings relation
 *
 * @method     ChildMailingQuery leftJoinWithVictimMailings() Adds a LEFT JOIN clause and with to the query using the VictimMailings relation
 * @method     ChildMailingQuery rightJoinWithVictimMailings() Adds a RIGHT JOIN clause and with to the query using the VictimMailings relation
 * @method     ChildMailingQuery innerJoinWithVictimMailings() Adds a INNER JOIN clause and with to the query using the VictimMailings relation
 *
 * @method     ChildMailingQuery leftJoinUserMailings($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserMailings relation
 * @method     ChildMailingQuery rightJoinUserMailings($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserMailings relation
 * @method     ChildMailingQuery innerJoinUserMailings($relationAlias = null) Adds a INNER JOIN clause to the query using the UserMailings relation
 *
 * @method     ChildMailingQuery joinWithUserMailings($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserMailings relation
 *
 * @method     ChildMailingQuery leftJoinWithUserMailings() Adds a LEFT JOIN clause and with to the query using the UserMailings relation
 * @method     ChildMailingQuery rightJoinWithUserMailings() Adds a RIGHT JOIN clause and with to the query using the UserMailings relation
 * @method     ChildMailingQuery innerJoinWithUserMailings() Adds a INNER JOIN clause and with to the query using the UserMailings relation
 *
 * @method     ChildMailingQuery leftJoinGroupMailings($relationAlias = null) Adds a LEFT JOIN clause to the query using the GroupMailings relation
 * @method     ChildMailingQuery rightJoinGroupMailings($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GroupMailings relation
 * @method     ChildMailingQuery innerJoinGroupMailings($relationAlias = null) Adds a INNER JOIN clause to the query using the GroupMailings relation
 *
 * @method     ChildMailingQuery joinWithGroupMailings($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the GroupMailings relation
 *
 * @method     ChildMailingQuery leftJoinWithGroupMailings() Adds a LEFT JOIN clause and with to the query using the GroupMailings relation
 * @method     ChildMailingQuery rightJoinWithGroupMailings() Adds a RIGHT JOIN clause and with to the query using the GroupMailings relation
 * @method     ChildMailingQuery innerJoinWithGroupMailings() Adds a INNER JOIN clause and with to the query using the GroupMailings relation
 *
 * @method     \DB\WebVisitQuery|\DB\WebConversionQuery|\DB\VictimMailingsQuery|\DB\UserMailingsQuery|\DB\GroupMailingsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildMailing findOne(ConnectionInterface $con = null) Return the first ChildMailing matching the query
 * @method     ChildMailing findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMailing matching the query, or a new ChildMailing object populated from the query conditions when no match is found
 *
 * @method     ChildMailing findOneById(int $id) Return the first ChildMailing filtered by the id column
 * @method     ChildMailing findOneByName(string $name) Return the first ChildMailing filtered by the name column
 * @method     ChildMailing findOneByHeadline(string $headline) Return the first ChildMailing filtered by the headline column
 * @method     ChildMailing findOneByContent(string $content) Return the first ChildMailing filtered by the content column
 * @method     ChildMailing findOneByDescription(string $description) Return the first ChildMailing filtered by the description column
 * @method     ChildMailing findOneByFromemail(string $fromEmail) Return the first ChildMailing filtered by the fromEmail column
 * @method     ChildMailing findOneByFromname(string $fromName) Return the first ChildMailing filtered by the fromName column
 * @method     ChildMailing findOneByTracking(int $tracking) Return the first ChildMailing filtered by the tracking column
 * @method     ChildMailing findOneByIssmtp(boolean $isSmtp) Return the first ChildMailing filtered by the isSmtp column
 * @method     ChildMailing findOneBySmtphost(string $smtpHost) Return the first ChildMailing filtered by the smtpHost column
 * @method     ChildMailing findOneBySmtpuser(string $smtpUser) Return the first ChildMailing filtered by the smtpUser column
 * @method     ChildMailing findOneBySmtppassword(string $smtpPassword) Return the first ChildMailing filtered by the smtpPassword column
 * @method     ChildMailing findOneBySmtpsecure(string $smtpSecure) Return the first ChildMailing filtered by the smtpSecure column
 * @method     ChildMailing findOneBySmtpport(string $smtpPort) Return the first ChildMailing filtered by the smtpPort column *

 * @method     ChildMailing requirePk($key, ConnectionInterface $con = null) Return the ChildMailing by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMailing requireOne(ConnectionInterface $con = null) Return the first ChildMailing matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMailing requireOneById(int $id) Return the first ChildMailing filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMailing requireOneByName(string $name) Return the first ChildMailing filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMailing requireOneByHeadline(string $headline) Return the first ChildMailing filtered by the headline column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMailing requireOneByContent(string $content) Return the first ChildMailing filtered by the content column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMailing requireOneByDescription(string $description) Return the first ChildMailing filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMailing requireOneByFromemail(string $fromEmail) Return the first ChildMailing filtered by the fromEmail column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMailing requireOneByFromname(string $fromName) Return the first ChildMailing filtered by the fromName column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMailing requireOneByTracking(int $tracking) Return the first ChildMailing filtered by the tracking column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMailing requireOneByIssmtp(boolean $isSmtp) Return the first ChildMailing filtered by the isSmtp column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMailing requireOneBySmtphost(string $smtpHost) Return the first ChildMailing filtered by the smtpHost column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMailing requireOneBySmtpuser(string $smtpUser) Return the first ChildMailing filtered by the smtpUser column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMailing requireOneBySmtppassword(string $smtpPassword) Return the first ChildMailing filtered by the smtpPassword column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMailing requireOneBySmtpsecure(string $smtpSecure) Return the first ChildMailing filtered by the smtpSecure column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMailing requireOneBySmtpport(string $smtpPort) Return the first ChildMailing filtered by the smtpPort column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMailing[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildMailing objects based on current ModelCriteria
 * @method     ChildMailing[]|ObjectCollection findById(int $id) Return ChildMailing objects filtered by the id column
 * @method     ChildMailing[]|ObjectCollection findByName(string $name) Return ChildMailing objects filtered by the name column
 * @method     ChildMailing[]|ObjectCollection findByHeadline(string $headline) Return ChildMailing objects filtered by the headline column
 * @method     ChildMailing[]|ObjectCollection findByContent(string $content) Return ChildMailing objects filtered by the content column
 * @method     ChildMailing[]|ObjectCollection findByDescription(string $description) Return ChildMailing objects filtered by the description column
 * @method     ChildMailing[]|ObjectCollection findByFromemail(string $fromEmail) Return ChildMailing objects filtered by the fromEmail column
 * @method     ChildMailing[]|ObjectCollection findByFromname(string $fromName) Return ChildMailing objects filtered by the fromName column
 * @method     ChildMailing[]|ObjectCollection findByTracking(int $tracking) Return ChildMailing objects filtered by the tracking column
 * @method     ChildMailing[]|ObjectCollection findByIssmtp(boolean $isSmtp) Return ChildMailing objects filtered by the isSmtp column
 * @method     ChildMailing[]|ObjectCollection findBySmtphost(string $smtpHost) Return ChildMailing objects filtered by the smtpHost column
 * @method     ChildMailing[]|ObjectCollection findBySmtpuser(string $smtpUser) Return ChildMailing objects filtered by the smtpUser column
 * @method     ChildMailing[]|ObjectCollection findBySmtppassword(string $smtpPassword) Return ChildMailing objects filtered by the smtpPassword column
 * @method     ChildMailing[]|ObjectCollection findBySmtpsecure(string $smtpSecure) Return ChildMailing objects filtered by the smtpSecure column
 * @method     ChildMailing[]|ObjectCollection findBySmtpport(string $smtpPort) Return ChildMailing objects filtered by the smtpPort column
 * @method     ChildMailing[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class MailingQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \DB\Base\MailingQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\DB\\Mailing', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMailingQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMailingQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildMailingQuery) {
            return $criteria;
        }
        $query = new ChildMailingQuery();
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
     * @return ChildMailing|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MailingTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = MailingTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildMailing A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, headline, content, description, fromEmail, fromName, tracking, isSmtp, smtpHost, smtpUser, smtpPassword, smtpSecure, smtpPort FROM Mailings WHERE id = :p0';
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
            /** @var ChildMailing $obj */
            $obj = new ChildMailing();
            $obj->hydrate($row);
            MailingTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildMailing|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildMailingQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MailingTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildMailingQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MailingTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildMailingQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(MailingTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(MailingTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MailingTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMailingQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MailingTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the headline column
     *
     * Example usage:
     * <code>
     * $query->filterByHeadline('fooValue');   // WHERE headline = 'fooValue'
     * $query->filterByHeadline('%fooValue%', Criteria::LIKE); // WHERE headline LIKE '%fooValue%'
     * </code>
     *
     * @param     string $headline The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMailingQuery The current query, for fluid interface
     */
    public function filterByHeadline($headline = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($headline)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MailingTableMap::COL_HEADLINE, $headline, $comparison);
    }

    /**
     * Filter the query on the content column
     *
     * Example usage:
     * <code>
     * $query->filterByContent('fooValue');   // WHERE content = 'fooValue'
     * $query->filterByContent('%fooValue%', Criteria::LIKE); // WHERE content LIKE '%fooValue%'
     * </code>
     *
     * @param     string $content The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMailingQuery The current query, for fluid interface
     */
    public function filterByContent($content = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($content)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MailingTableMap::COL_CONTENT, $content, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%', Criteria::LIKE); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMailingQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MailingTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the fromEmail column
     *
     * Example usage:
     * <code>
     * $query->filterByFromemail('fooValue');   // WHERE fromEmail = 'fooValue'
     * $query->filterByFromemail('%fooValue%', Criteria::LIKE); // WHERE fromEmail LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fromemail The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMailingQuery The current query, for fluid interface
     */
    public function filterByFromemail($fromemail = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fromemail)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MailingTableMap::COL_FROMEMAIL, $fromemail, $comparison);
    }

    /**
     * Filter the query on the fromName column
     *
     * Example usage:
     * <code>
     * $query->filterByFromname('fooValue');   // WHERE fromName = 'fooValue'
     * $query->filterByFromname('%fooValue%', Criteria::LIKE); // WHERE fromName LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fromname The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMailingQuery The current query, for fluid interface
     */
    public function filterByFromname($fromname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fromname)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MailingTableMap::COL_FROMNAME, $fromname, $comparison);
    }

    /**
     * Filter the query on the tracking column
     *
     * Example usage:
     * <code>
     * $query->filterByTracking(1234); // WHERE tracking = 1234
     * $query->filterByTracking(array(12, 34)); // WHERE tracking IN (12, 34)
     * $query->filterByTracking(array('min' => 12)); // WHERE tracking > 12
     * </code>
     *
     * @param     mixed $tracking The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMailingQuery The current query, for fluid interface
     */
    public function filterByTracking($tracking = null, $comparison = null)
    {
        if (is_array($tracking)) {
            $useMinMax = false;
            if (isset($tracking['min'])) {
                $this->addUsingAlias(MailingTableMap::COL_TRACKING, $tracking['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($tracking['max'])) {
                $this->addUsingAlias(MailingTableMap::COL_TRACKING, $tracking['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MailingTableMap::COL_TRACKING, $tracking, $comparison);
    }

    /**
     * Filter the query on the isSmtp column
     *
     * Example usage:
     * <code>
     * $query->filterByIssmtp(true); // WHERE isSmtp = true
     * $query->filterByIssmtp('yes'); // WHERE isSmtp = true
     * </code>
     *
     * @param     boolean|string $issmtp The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMailingQuery The current query, for fluid interface
     */
    public function filterByIssmtp($issmtp = null, $comparison = null)
    {
        if (is_string($issmtp)) {
            $issmtp = in_array(strtolower($issmtp), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(MailingTableMap::COL_ISSMTP, $issmtp, $comparison);
    }

    /**
     * Filter the query on the smtpHost column
     *
     * Example usage:
     * <code>
     * $query->filterBySmtphost('fooValue');   // WHERE smtpHost = 'fooValue'
     * $query->filterBySmtphost('%fooValue%', Criteria::LIKE); // WHERE smtpHost LIKE '%fooValue%'
     * </code>
     *
     * @param     string $smtphost The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMailingQuery The current query, for fluid interface
     */
    public function filterBySmtphost($smtphost = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($smtphost)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MailingTableMap::COL_SMTPHOST, $smtphost, $comparison);
    }

    /**
     * Filter the query on the smtpUser column
     *
     * Example usage:
     * <code>
     * $query->filterBySmtpuser('fooValue');   // WHERE smtpUser = 'fooValue'
     * $query->filterBySmtpuser('%fooValue%', Criteria::LIKE); // WHERE smtpUser LIKE '%fooValue%'
     * </code>
     *
     * @param     string $smtpuser The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMailingQuery The current query, for fluid interface
     */
    public function filterBySmtpuser($smtpuser = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($smtpuser)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MailingTableMap::COL_SMTPUSER, $smtpuser, $comparison);
    }

    /**
     * Filter the query on the smtpPassword column
     *
     * Example usage:
     * <code>
     * $query->filterBySmtppassword('fooValue');   // WHERE smtpPassword = 'fooValue'
     * $query->filterBySmtppassword('%fooValue%', Criteria::LIKE); // WHERE smtpPassword LIKE '%fooValue%'
     * </code>
     *
     * @param     string $smtppassword The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMailingQuery The current query, for fluid interface
     */
    public function filterBySmtppassword($smtppassword = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($smtppassword)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MailingTableMap::COL_SMTPPASSWORD, $smtppassword, $comparison);
    }

    /**
     * Filter the query on the smtpSecure column
     *
     * Example usage:
     * <code>
     * $query->filterBySmtpsecure('fooValue');   // WHERE smtpSecure = 'fooValue'
     * $query->filterBySmtpsecure('%fooValue%', Criteria::LIKE); // WHERE smtpSecure LIKE '%fooValue%'
     * </code>
     *
     * @param     string $smtpsecure The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMailingQuery The current query, for fluid interface
     */
    public function filterBySmtpsecure($smtpsecure = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($smtpsecure)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MailingTableMap::COL_SMTPSECURE, $smtpsecure, $comparison);
    }

    /**
     * Filter the query on the smtpPort column
     *
     * Example usage:
     * <code>
     * $query->filterBySmtpport('fooValue');   // WHERE smtpPort = 'fooValue'
     * $query->filterBySmtpport('%fooValue%', Criteria::LIKE); // WHERE smtpPort LIKE '%fooValue%'
     * </code>
     *
     * @param     string $smtpport The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMailingQuery The current query, for fluid interface
     */
    public function filterBySmtpport($smtpport = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($smtpport)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MailingTableMap::COL_SMTPPORT, $smtpport, $comparison);
    }

    /**
     * Filter the query by a related \DB\WebVisit object
     *
     * @param \DB\WebVisit|ObjectCollection $webVisit the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMailingQuery The current query, for fluid interface
     */
    public function filterByWebVisit($webVisit, $comparison = null)
    {
        if ($webVisit instanceof \DB\WebVisit) {
            return $this
                ->addUsingAlias(MailingTableMap::COL_ID, $webVisit->getMailingId(), $comparison);
        } elseif ($webVisit instanceof ObjectCollection) {
            return $this
                ->useWebVisitQuery()
                ->filterByPrimaryKeys($webVisit->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByWebVisit() only accepts arguments of type \DB\WebVisit or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the WebVisit relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMailingQuery The current query, for fluid interface
     */
    public function joinWebVisit($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('WebVisit');

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
            $this->addJoinObject($join, 'WebVisit');
        }

        return $this;
    }

    /**
     * Use the WebVisit relation WebVisit object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DB\WebVisitQuery A secondary query class using the current class as primary query
     */
    public function useWebVisitQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinWebVisit($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'WebVisit', '\DB\WebVisitQuery');
    }

    /**
     * Filter the query by a related \DB\WebConversion object
     *
     * @param \DB\WebConversion|ObjectCollection $webConversion the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMailingQuery The current query, for fluid interface
     */
    public function filterByWebConversion($webConversion, $comparison = null)
    {
        if ($webConversion instanceof \DB\WebConversion) {
            return $this
                ->addUsingAlias(MailingTableMap::COL_ID, $webConversion->getMailingId(), $comparison);
        } elseif ($webConversion instanceof ObjectCollection) {
            return $this
                ->useWebConversionQuery()
                ->filterByPrimaryKeys($webConversion->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByWebConversion() only accepts arguments of type \DB\WebConversion or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the WebConversion relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMailingQuery The current query, for fluid interface
     */
    public function joinWebConversion($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('WebConversion');

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
            $this->addJoinObject($join, 'WebConversion');
        }

        return $this;
    }

    /**
     * Use the WebConversion relation WebConversion object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DB\WebConversionQuery A secondary query class using the current class as primary query
     */
    public function useWebConversionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinWebConversion($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'WebConversion', '\DB\WebConversionQuery');
    }

    /**
     * Filter the query by a related \DB\VictimMailings object
     *
     * @param \DB\VictimMailings|ObjectCollection $victimMailings the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMailingQuery The current query, for fluid interface
     */
    public function filterByVictimMailings($victimMailings, $comparison = null)
    {
        if ($victimMailings instanceof \DB\VictimMailings) {
            return $this
                ->addUsingAlias(MailingTableMap::COL_ID, $victimMailings->getMailingId(), $comparison);
        } elseif ($victimMailings instanceof ObjectCollection) {
            return $this
                ->useVictimMailingsQuery()
                ->filterByPrimaryKeys($victimMailings->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByVictimMailings() only accepts arguments of type \DB\VictimMailings or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the VictimMailings relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMailingQuery The current query, for fluid interface
     */
    public function joinVictimMailings($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('VictimMailings');

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
            $this->addJoinObject($join, 'VictimMailings');
        }

        return $this;
    }

    /**
     * Use the VictimMailings relation VictimMailings object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DB\VictimMailingsQuery A secondary query class using the current class as primary query
     */
    public function useVictimMailingsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinVictimMailings($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'VictimMailings', '\DB\VictimMailingsQuery');
    }

    /**
     * Filter the query by a related \DB\UserMailings object
     *
     * @param \DB\UserMailings|ObjectCollection $userMailings the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMailingQuery The current query, for fluid interface
     */
    public function filterByUserMailings($userMailings, $comparison = null)
    {
        if ($userMailings instanceof \DB\UserMailings) {
            return $this
                ->addUsingAlias(MailingTableMap::COL_ID, $userMailings->getMailingId(), $comparison);
        } elseif ($userMailings instanceof ObjectCollection) {
            return $this
                ->useUserMailingsQuery()
                ->filterByPrimaryKeys($userMailings->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUserMailings() only accepts arguments of type \DB\UserMailings or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserMailings relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMailingQuery The current query, for fluid interface
     */
    public function joinUserMailings($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserMailings');

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
            $this->addJoinObject($join, 'UserMailings');
        }

        return $this;
    }

    /**
     * Use the UserMailings relation UserMailings object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DB\UserMailingsQuery A secondary query class using the current class as primary query
     */
    public function useUserMailingsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserMailings($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserMailings', '\DB\UserMailingsQuery');
    }

    /**
     * Filter the query by a related \DB\GroupMailings object
     *
     * @param \DB\GroupMailings|ObjectCollection $groupMailings the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMailingQuery The current query, for fluid interface
     */
    public function filterByGroupMailings($groupMailings, $comparison = null)
    {
        if ($groupMailings instanceof \DB\GroupMailings) {
            return $this
                ->addUsingAlias(MailingTableMap::COL_ID, $groupMailings->getMailingId(), $comparison);
        } elseif ($groupMailings instanceof ObjectCollection) {
            return $this
                ->useGroupMailingsQuery()
                ->filterByPrimaryKeys($groupMailings->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGroupMailings() only accepts arguments of type \DB\GroupMailings or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GroupMailings relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMailingQuery The current query, for fluid interface
     */
    public function joinGroupMailings($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GroupMailings');

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
            $this->addJoinObject($join, 'GroupMailings');
        }

        return $this;
    }

    /**
     * Use the GroupMailings relation GroupMailings object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DB\GroupMailingsQuery A secondary query class using the current class as primary query
     */
    public function useGroupMailingsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGroupMailings($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GroupMailings', '\DB\GroupMailingsQuery');
    }

    /**
     * Filter the query by a related User object
     * using the User_Mailings table as cross reference
     *
     * @param User $user the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMailingQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useUserMailingsQuery()
            ->filterByUser($user, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Group object
     * using the Group_Mailings table as cross reference
     *
     * @param Group $group the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMailingQuery The current query, for fluid interface
     */
    public function filterByGroup($group, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useGroupMailingsQuery()
            ->filterByGroup($group, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildMailing $mailing Object to remove from the list of results
     *
     * @return $this|ChildMailingQuery The current query, for fluid interface
     */
    public function prune($mailing = null)
    {
        if ($mailing) {
            $this->addUsingAlias(MailingTableMap::COL_ID, $mailing->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the Mailings table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MailingTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MailingTableMap::clearInstancePool();
            MailingTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(MailingTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MailingTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            MailingTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            MailingTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // MailingQuery
