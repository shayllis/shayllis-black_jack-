<?php
namespace App\Test\TestCase\Model\Table;

use Faker\Generator;
use Faker\Provider\pt_BR\Person;
use Faker\Provider\pt_BR\Address;
use App\Model\Table\DecksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;


/**
 * App\Model\Table\AddressesTable Test Case
 */
class DecksTableTest extends TestCase
{
  public $Deck;

  public function setUp()
  {
    parent::setUp();
    $config = TableRegistry::getTableLocator()->exists('Decks') ? [] : ['className' => DecksTable::class];
    $this->Decks = TableRegistry::getTableLocator()->get('Decks', $config);
  }

  /**
   * tearDown method
   *
   * @return void
   */
  public function tearDown()
  {
    unset($this->Decks);

    parent::tearDown();
  }

  public function testGenerateDeck()
  {
    /*
    [
      [
        'kind' => 'string',
        'number' => 'string'
      ]
    ]*/

    $response = $this->Decks->generateDeck();

    $this->assertEquals(52, count($response));

    $kinds = [
      'hearts' => [],
      'spades' => [],
      'clubs' => [],
      'diamonds' => []
    ];

    foreach ($response as $card) {
      $kinds[$card['kind']][] = $card['number'];
    }
    foreach ($kinds as $k => $cards) {
      $kinds[$k] = array_unique($cards);
      sort($kinds[$k]);
    }

    $this->assertEquals(13, count($kinds['hearts']));
    $this->assertEquals(13, count($kinds['spades']));
    $this->assertEquals(13, count($kinds['clubs']));
    $this->assertEquals(13, count($kinds['diamonds']));

    $cards = ['J', 'K', 'Q', 1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

    $this->assertEquals($cards, $kinds['hearts']);
    $this->assertEquals($cards, $kinds['spades']);
    $this->assertEquals($cards, $kinds['clubs']);
    $this->assertEquals($cards, $kinds['diamonds']);
  }

  public function testShuffle()
  {
    $deck = $this->Decks->generateDeck();
    $shuffledDeck = $this->Decks->shuffle($deck);
    $shuffledAgainDeck = $this->Decks->shuffle($deck);

    $this->assertNotEquals($deck, $shuffledDeck);
    $this->assertNotEquals($shuffledDeck, $shuffledAgainDeck); // Check whether it has been really shuffled
  }

  public function testPickCard()
  {
    $deck = $this->Decks->generateDeck();
    $card = $this->Decks->pickCard($deck);

    $this->assertTrue(is_array($card));
    $this->assertEquals(['kind', 'number'], array_keys($card));
    $this->assertTrue(in_array($card['kind'], ['hearts', 'spades', 'clubs', 'diamonds']));
    $this->assertTrue(in_array($card['number'], ['J', 'K', 'Q', 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]));
    $this->assertEquals(51, count($deck));
    $this->assertFalse(in_array($card, $deck));
  }
}
