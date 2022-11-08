<?php
require_once("../includes/bootstrap.php");

/**
 * Class CategoryTest
 */
class CategoryTest {
	private $category;
	private $dbc;

	/**
	 * CategoryTest constructor.
	 * @param Database $dbc
	 */
	public function __construct(Database $dbc) {
		$this->dbc = $dbc;
	}

	/**
	 * @return bool
	 */
	public function tearDown() {
		$result = $this->dbc->sqlQuery("DELETE FROM `categories` WHERE `cat` = 'TestCategory'");
		return ($result->rowCount() >= 1) ? true : false;
	}

	/**
	 * @return bool
	 */
	public function testCreate() {
		$this->category = new Category("0", "TestCategory");
		$result = $this->category->create();
		return ($result->rowCount() == 1) ? true : false;
	}

	/**
	 * @return bool
	 */
	public function testFind() {
		$category = Category::find("SELECT * from `categories` WHERE `cat` = :cat", ["cat" => "TestCategory"]);

		if(count($category) >= 1) {
			$this->category = array_shift($category);

			return true;
		} else {
			return false;
		}
	}

	/**
	 * @return bool
	 */
	public function testAll() {
		$category = Category::all();
		return (count($category) >= 1) ? true : false;
	}

}

$categoryTest = new CategoryTest($dbc);

echo "Test #1 TestCreate ...";
echo $categoryTest->testCreate() ? "Test passed" : "Test Failed";
echo "<br>";

echo "Test #2 TestFind ...";
echo $categoryTest->testFind() ? "Test passed" : "Test Failed";
echo "<br>";

echo "Test #3 TestAll ...";
echo $categoryTest->testAll() ? "Test passed" : "Test Failed";
echo "<br>";

echo "Clean up ...";
echo $categoryTest->tearDown() ? "done" : "failed";
echo "<br>";
