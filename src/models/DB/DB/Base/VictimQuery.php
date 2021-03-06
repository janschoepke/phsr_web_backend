<?php

namespace DB\Base;

use \Exception;
use \PDO;
use DB\Victim as ChildVictim;
use DB\VictimQuery as ChildVictimQuery;
use DB\Map\VictimTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'Victims' table.
 *
 *
 *
 * @method     ChildVictimQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildVictimQuery orderByFirstname($order = Criteria::ASC) Order by the firstname column
 * @method     ChildVictimQuery orderByLastname($order = Criteria::ASC) Order by the lastname column
 * @method     ChildVictimQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     ChildVictimQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildVictimQuery orderByGender($order = Criteria::ASC) Order by the gender column
 * @method     ChildVictimQuery orderByBirthday($order = Criteria::ASC) Order by the birthday column
 *
 * @method     ChildVictimQuery groupById() Group by the id column
 * @method     ChildVictimQuery groupByFirstname() Group by the firstname column
 * @method     ChildVictimQuery groupByLastname() Group by the lastname column
 * @method     ChildVictimQuery groupByEmail() Group by the email column
 * @method     ChildVictimQuery groupByDescription() Group by the description column
 * @method     ChildVictimQuery groupByGender() Group by the gender column
 * @method     ChildVictimQuery groupByBirthday() Group by the birthday column
 *
 * @method     ChildVictimQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildVictimQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildVictimQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildVictimQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildVictimQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildVictimQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildVictimQuery leftJoinWebVisit($relationAlias = null) Adds a LEFT JOIN clause to the query using the WebVisit relation
 * @method     ChildVictimQuery rightJoinWebVisit($relationAlias = null) Adds a RIGHT JOIN clause to the query using the WebVisit relation
 * @method     ChildVictimQuery innerJoinWebVisit($relationAlias = null) Adds a INNER JOIN clause to the query using the WebVisit relation
 *
 * @method     ChildVictimQuery joinWithWebVisit($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the WebVisit relation
 *
 * @method     ChildVictimQuery leftJoinWithWebVisit() Adds a LEFT JOIN clause and with to the query using the WebVisit relation
 * @method     ChildVictimQuery rightJoinWithWebVisit() Adds a RIGHT JOIN clause and with to the query using the WebVisit relation
 * @method     ChildVictimQuery innerJoinWithWebVisit() Adds a INNER JOIN clause and with to the query using the WebVisit relation
 *
 * @method     ChildVictimQuery leftJoinWebConversion($relationAlias = null) Adds a LEFT JOIN clause to the query using the WebConversion relation
 * @method     ChildVictimQuery rightJoinWebConversion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the WebConversion relation
 * @method     ChildVictimQuery innerJoinWebConversion($relationAlias = null) Adds a INNER JOIN clause to the query using the WebConversion relation
 *
 * @method     ChildVictimQuery joinWithWebConversion($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the WebConversion relation
 *
 * @method     ChildVictimQuery leftJoinWithWebConversion() Adds a LEFT JOIN clause and with to the query using the WebConversion relation
 * @method     ChildVictimQuery rightJoinWithWebConversion() Adds a RIGHT JOIN clause and with to the query using the WebConversion relation
 * @method     ChildVictimQuery innerJoinWithWebConversion() Adds a INNER JOIN clause and with to the query using the WebConversion relation
 *
 * @method     ChildVictimQuery leftJoinGroupVictims($relationAlias = null) Adds a LEFT JOIN clause to the query using the GroupVictims relation
 * @method     ChildVictimQuery rightJoinGroupVictims($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GroupVictims relation
 * @method     ChildVictimQuery innerJoinGroupVictims($relationAlias = null) Adds a INNER JOIN clause to the query using the GroupVictims relation
 *
 * @method     ChildVictimQuery joinWithGroupVictims($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the GroupVictims relation
 *
 * @method     ChildVictimQuery leftJoinWithGroupVictims() Adds a LEFT JOIN clause and with to the query using the GroupVictims relation
 * @method     ChildVictimQuery rightJoinWithGroupVictims() Adds a RIGHT JOIN clause and with to the query using the GroupVictims relation
 * @method     ChildVictimQuery innerJoinWithGroupVictims() Adds a INNER JOIN clause and with to the query using the GroupVictims relation
 *
 * @method     ChildVictimQuery leftJoinUserVictims($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserVictims relation
 * @method     ChildVictimQuery rightJoinUserVictims($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserVictims relation
 * @method     ChildVictimQuery innerJoinUserVictims($relationAlias = null) Adds a INNER JOIN clause to the query using the UserVictims relation
 *
 * @method     ChildVictimQuery joinWithUserVictims($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserVictims relation
 *
 * @method     ChildVictimQuery leftJoinWithUserVictims() Adds a LEFT JOIN clause and with to the query using the UserVictims relation
 * @method     ChildVictimQuery rightJoinWithUserVictims() Adds a RIGHT JOIN clause and with to the query using the UserVictims relation
 * @method     ChildVictimQuery innerJoinWithUserVictims() Adds a INNER JOIN clause and with to the query using the UserVictims relation
 *
 * @method     ChildVictimQuery leftJoinVictimMailings($relationAlias = null) Adds a LEFT JOIN clause to the query using the VictimMailings relation
 * @method     ChildVictimQuery rightJoinVictimMailings($relationAlias = null) Adds a RIGHT JOIN clause to the query using the VictimMailings relation
 * @method     ChildVictimQuery innerJoinVictimMailings($relationAlias = null) Adds a INNER JOIN clause to the query using the VictimMailings relation
 *
 * @method     ChildVictimQuery joinWithVictimMailings($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the VictimMailings relation
 *
 * @method     ChildVictimQuery leftJoinWithVictimMailings() Adds a LEFT JOIN clause and with to the query using the VictimMailings relation
 * @method     ChildVictimQuery rightJoinWithVictimMailings() Adds a RIGHT JOIN clause and with to the query using the VictimMailings relation
 * @method     ChildVictimQuery innerJoinWithVictimMailings() Adds a INNER JOIN clause and with to the query using the VictimMailings relation
 *
 * @method     \DB\WebVisitQuery|\DB\WebConversionQuery|\DB\GroupVictimsQuery|\DB\UserVictimsQuery|\DB\VictimMailingsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildVictim findOne(ConnectionInterface $con = null) Return the first ChildVictim matching the query
 * @method     ChildVictim findOneOrCreate(ConnectionInterface $con = null) Return the first ChildVictim matching the query, or a new ChildVictim object populated from the query conditions when no match is found
 *
 * @method     ChildVictim findOneById(int $id) Return the first ChildVictim filtered by the id column
 * @method     ChildVictim findOneByFirstname(string $firstname) Return the first ChildVictim filtered by the firstname column
 * @method     ChildVictim findOneByLastname(string $lastname) Return the first ChildVictim filtered by the lastname column
 * @method     ChildVictim findOneByEmail(string $email) Return the first ChildVictim filtered by the email column
 * @method     ChildVictim findOneByDescription(string $description) Return the first ChildVictim filtered by the description column
 * @method     ChildVictim findOneByGender(boolean $gender) Return the first ChildVictim filtered by the gender column
 * @method     ChildVictim findOneByBirthday(string $birthday) Return the first ChildVictim filtered by the birthday column *

 * @method     ChildVictim requirePk($key, ConnectionInterface $con = null) Return the ChildVictim by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVictim requireOne(ConnectionInterface $con = null) Return the first ChildVictim matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildVictim requireOneById(int $id) Return the first ChildVictim filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVictim requireOneByFirstname(string $firstname) Return the first ChildVictim filtered by the firstname column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVictim requireOneByLastname(string $lastname) Return the first ChildVictim filtered by the lastname column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVictim requireOneByEmail(string $email) Return the first ChildVictim filtered by the email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVictim requireOneByDescription(string $description) Return the first ChildVictim filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVictim requireOneByGender(boolean $gender) Return the first ChildVictim filtered by the gender column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVictim requireOneByBirthday(string $birthday) Return the first ChildVictim filtered by the birthday column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildVictim[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildVictim objects based on current ModelCriteria
 * @method     ChildVictim[]|ObjectCollection findById(int $id) Return ChildVictim objects filtered by the id column
 * @method     ChildVictim[]|ObjectCollection findByFirstname(string $firstname) Return ChildVictim objects filtered by the firstname column
 * @method     ChildVictim[]|ObjectCollection findByLastname(string $lastname) Return ChildVictim objects filtered by the lastname column
 * @method     ChildVictim[]|ObjectCollection findByEmail(string $email) Return ChildVictim objects filtered by the email column
 * @method     ChildVictim[]|ObjectCollection findByDescription(string $description) Return ChildVictim objects filtered by the description column
 * @method     ChildVictim[]|ObjectCollection findByGender(boolean $gender) Return ChildVictim objects filtered by the gender column
 * @method     ChildVictim[]|ObjectCollection findByBirthday(string $birthday) Return ChildVictim objects filtered by the birthday column
 * @method     ChildVictim[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class VictimQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \DB\Base\VictimQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\DB\\Victim', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildVictimQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildVictimQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildVictimQuery) {
            return $criteria;
        }
        $query = new ChildVictimQuery();
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
     * @return ChildVictim|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(VictimTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = VictimTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildVictim A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, firstname, lastname, email, description, gender, birthday FROM Victims WHERE id = :p0';
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
            /** @var ChildVictim $obj */
            $obj = new ChildVictim();
            $obj->hydrate($row);
            VictimTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildVictim|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildVictimQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(VictimTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildVictimQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(VictimTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildVictimQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(VictimTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(VictimTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VictimTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the firstname column
     *
     * Example usage:
     * <code>
     * $query->filterByFirstname('fooValue');   // WHERE firstname = 'fooValue'
     * $query->filterByFirstname('%fooValue%', Criteria::LIKE); // WHERE firstname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $firstname The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVictimQuery The current query, for fluid interface
     */
    public function filterByFirstname($firstname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($firstname)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VictimTableMap::COL_FIRSTNAME, $firstname, $comparison);
    }

    /**
     * Filter the query on the lastname column
     *
     * Example usage:
     * <code>
     * $query->filterByLastname('fooValue');   // WHERE lastname = 'fooValue'
     * $query->filterByLastname('%fooValue%', Criteria::LIKE); // WHERE lastname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $lastname The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVictimQuery The current query, for fluid interface
     */
    public function filterByLastname($lastname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lastname)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VictimTableMap::COL_LASTNAME, $lastname, $comparison);
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%', Criteria::LIKE); // WHERE email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVictimQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VictimTableMap::COL_EMAIL, $email, $comparison);
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
     * @return $this|ChildVictimQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VictimTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the gender column
     *
     * Example usage:
     * <code>
     * $query->filterByGender(true); // WHERE gender = true
     * $query->filterByGender('yes'); // WHERE gender = true
     * </code>
     *
     * @param     boolean|string $gender The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVictimQuery The current query, for fluid interface
     */
    public function filterByGender($gender = null, $comparison = null)
    {
        if (is_string($gender)) {
            $gender = in_array(strtolower($gender), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(VictimTableMap::COL_GENDER, $gender, $comparison);
    }

    /**
     * Filter the query on the birthday column
     *
     * Example usage:
     * <code>
     * $query->filterByBirthday('2011-03-14'); // WHERE birthday = '2011-03-14'
     * $query->filterByBirthday('now'); // WHERE birthday = '2011-03-14'
     * $query->filterByBirthday(array('max' => 'yesterday')); // WHERE birthday > '2011-03-13'
     * </code>
     *
     * @param     mixed $birthday The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVictimQuery The current query, for fluid interface
     */
    public function filterByBirthday($birthday = null, $comparison = null)
    {
        if (is_array($birthday)) {
            $useMinMax = false;
            if (isset($birthday['min'])) {
                $this->addUsingAlias(VictimTableMap::COL_BIRTHDAY, $birthday['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($birthday['max'])) {
                $this->addUsingAlias(VictimTableMap::COL_BIRTHDAY, $birthday['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VictimTableMap::COL_BIRTHDAY, $birthday, $comparison);
    }

    /**
     * Filter the query by a related \DB\WebVisit object
     *
     * @param \DB\WebVisit|ObjectCollection $webVisit the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildVictimQuery The current query, for fluid interface
     */
    public function filterByWebVisit($webVisit, $comparison = null)
    {
        if ($webVisit instanceof \DB\WebVisit) {
            return $this
                ->addUsingAlias(VictimTableMap::COL_ID, $webVisit->getVictimId(), $comparison);
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
     * @return $this|ChildVictimQuery The current query, for fluid interface
     */
    public function joinWebVisit($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useWebVisitQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
     * @return ChildVictimQuery The current query, for fluid interface
     */
    public function filterByWebConversion($webConversion, $comparison = null)
    {
        if ($webConversion instanceof \DB\WebConversion) {
            return $this
                ->addUsingAlias(VictimTableMap::COL_ID, $webConversion->getVictimId(), $comparison);
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
     * @return $this|ChildVictimQuery The current query, for fluid interface
     */
    public function joinWebConversion($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useWebConversionQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinWebConversion($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'WebConversion', '\DB\WebConversionQuery');
    }

    /**
     * Filter the query by a related \DB\GroupVictims object
     *
     * @param \DB\GroupVictims|ObjectCollection $groupVictims the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildVictimQuery The current query, for fluid interface
     */
    public function filterByGroupVictims($groupVictims, $comparison = null)
    {
        if ($groupVictims instanceof \DB\GroupVictims) {
            return $this
                ->addUsingAlias(VictimTableMap::COL_ID, $groupVictims->getVictimId(), $comparison);
        } elseif ($groupVictims instanceof ObjectCollection) {
            return $this
                ->useGroupVictimsQuery()
                ->filterByPrimaryKeys($groupVictims->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGroupVictims() only accepts arguments of type \DB\GroupVictims or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GroupVictims relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildVictimQuery The current query, for fluid interface
     */
    public function joinGroupVictims($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GroupVictims');

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
            $this->addJoinObject($join, 'GroupVictims');
        }

        return $this;
    }

    /**
     * Use the GroupVictims relation GroupVictims object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DB\GroupVictimsQuery A secondary query class using the current class as primary query
     */
    public function useGroupVictimsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGroupVictims($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GroupVictims', '\DB\GroupVictimsQuery');
    }

    /**
     * Filter the query by a related \DB\UserVictims object
     *
     * @param \DB\UserVictims|ObjectCollection $userVictims the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildVictimQuery The current query, for fluid interface
     */
    public function filterByUserVictims($userVictims, $comparison = null)
    {
        if ($userVictims instanceof \DB\UserVictims) {
            return $this
                ->addUsingAlias(VictimTableMap::COL_ID, $userVictims->getVictimId(), $comparison);
        } elseif ($userVictims instanceof ObjectCollection) {
            return $this
                ->useUserVictimsQuery()
                ->filterByPrimaryKeys($userVictims->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUserVictims() only accepts arguments of type \DB\UserVictims or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserVictims relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildVictimQuery The current query, for fluid interface
     */
    public function joinUserVictims($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserVictims');

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
            $this->addJoinObject($join, 'UserVictims');
        }

        return $this;
    }

    /**
     * Use the UserVictims relation UserVictims object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DB\UserVictimsQuery A secondary query class using the current class as primary query
     */
    public function useUserVictimsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserVictims($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserVictims', '\DB\UserVictimsQuery');
    }

    /**
     * Filter the query by a related \DB\VictimMailings object
     *
     * @param \DB\VictimMailings|ObjectCollection $victimMailings the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildVictimQuery The current query, for fluid interface
     */
    public function filterByVictimMailings($victimMailings, $comparison = null)
    {
        if ($victimMailings instanceof \DB\VictimMailings) {
            return $this
                ->addUsingAlias(VictimTableMap::COL_ID, $victimMailings->getVictimId(), $comparison);
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
     * @return $this|ChildVictimQuery The current query, for fluid interface
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
     * Filter the query by a related Group object
     * using the Group_Victims table as cross reference
     *
     * @param Group $group the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildVictimQuery The current query, for fluid interface
     */
    public function filterByGroup($group, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useGroupVictimsQuery()
            ->filterByGroup($group, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related User object
     * using the User_Victims table as cross reference
     *
     * @param User $user the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildVictimQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useUserVictimsQuery()
            ->filterByUser($user, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildVictim $victim Object to remove from the list of results
     *
     * @return $this|ChildVictimQuery The current query, for fluid interface
     */
    public function prune($victim = null)
    {
        if ($victim) {
            $this->addUsingAlias(VictimTableMap::COL_ID, $victim->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the Victims table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(VictimTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            VictimTableMap::clearInstancePool();
            VictimTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(VictimTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(VictimTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            VictimTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            VictimTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // VictimQuery
