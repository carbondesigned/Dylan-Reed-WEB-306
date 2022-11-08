<?php
require_once("../includes/bootstrap.php");


/**
 * Class EntryTest
 */
class EntryTest {
	private $entry;
	private $dbc;

	/**
	 * EntryTest constructor.
	 * @param Database $dbc
	 */
	public function __construct(Database $dbc) {
		$this->dbc = $dbc;
	}

	/**
	 * @return bool
	 */
	public function tearDown() {
		$result = $this->dbc->sqlQuery("DELETE FROM `entries` WHERE `body` = 'TestEntry' OR `body` = 'TestEntry2'");
		return ($result->rowCount() >= 1) ? true : false;
	}

	/**
	 * @return bool
	 */
	public function testCreate() {
		$this->entry = new Entry(0, 1, 0, "TestSubject", "TestEntry");
		$result = $this->entry->create();
		return ($result->rowCount() == 1) ? true : false;
	}

	/**
	 * @return bool
	 */
	public function testFind() {
		$entry = Entry::find("SELECT * from `entries` WHERE `body` = :entry", ["entry" => "TestEntry"]);

		if(count($entry) >= 1) {
			$this->entry = array_shift($entry);

			return true;
		} else {
			return false;
		}
	}

	/**
	 * @return bool
	 */
	public function testUpdate() {
		$result = $this->entry->setBody("TestEntry2")->update();
		return ($result->rowCount() >= 1) ? true : false;
	}

}

$entryTest = new EntryTest($dbc);

echo "Test #1 TestCreate ...";
echo $entryTest->testCreate() ? "Test passed" : "Test Failed";
echo "<br>";

echo "Test #2 TestFind ...";
echo $entryTest->testFind() ? "Test passed" : "Test Failed";
echo "<br>";

echo "Test #3 TestUpdate ...";
echo $entryTest->testUpdate() ? "Test passed" : "Test Failed";
echo "<br>";

echo "Clean up ...";
echo $entryTest->tearDown() ? "done" : "failed";
echo "<br>";
