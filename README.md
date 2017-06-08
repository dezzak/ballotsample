# Ballot Sample

PHP library to produce ballot sampling forms.

## Introduction

On polling day, people may vote for the same options at multiple polling stations, but the end result is only usually officially declared for a wider area consisting of many polling stations.

When the ballot boxes from each polling station arrive at the counting location, they are first counted to ensure that the number of ballot papers in the box matches the number of papers issued.
This provides an opportunity for interested parties to gain an idea of how a particular polling station has voted.

This library is intended to produce a form that agents at the count can use that is hopefully easier to use than a simple tally.

This library is not a front-end UI to enter the data needed to generate the form - you are responsible for that yourself.

The form will render a header with the title and date of the poll.
Below this will be a list of candidates and 99 boxes next to each candidate.
The intention is that each time an agent sees a vote for a candidate they mark the next box in the line for that candidate.
If the candidate name is too long to fit, the library will first try to remove the middle and first names of the candidate, and then reduce the size of the surname until it can fit in the box.
The candidates section is repeated for as many times as it can fit on the page.

### Parties

Some common political parties in the UK have been included (with logos taken from the Electoral Commission website).
If you find that you are missing a party, you can create one through the `PartyFactory`, and hopefully you will create a pull request so that others can use it.

## Quick start

```php
<?php
use Dezzak\BallotSample\Candidate;
use Dezzak\BallotSample\Output\FPDFAdapter;
use Dezzak\BallotSample\PartyFactory;
use Dezzak\BallotSample\Poll;
use Dezzak\BallotSample\SampleSheet;

$partyFactory = new PartyFactory();
$partyFactory->buildBaseParties();

$conservatives = $partyFactory->getParty('Conservatives');
$labour = $partyFactory->getParty('Labour');
$libdem = $partyFactory->getParty('Liberal Democrats');
$green = $partyFactory->getParty('Green');
$ukip = $partyFactory->getParty('UKIP');

$corbyn = new Candidate('Corbyn', 'Jeremy Bernard', $labour);
$farron = new Candidate('Farron', 'Timothy James', $libdem);
$lucas = new Candidate('Lucas', 'Caroline Patricia', $green);
$may = new Candidate('May', 'Theresa Mary', $conservatives);
$nuttall = new Candidate('Nuttall', 'Paul Andrew', $ukip);

$date = new DateTime('2017-06-08', new DateTimeZone('Europe/London'));

$poll = new Poll('Some Constituency', $date);
$poll->addCandidate($farron);
$poll->addCandidate($morris);
$poll->addCandidate($lucas);
$poll->addCandidate($may);
$poll->addCandidate($nuttall);

$pdf = new FPDFAdapter(new FPDF());

$sheet = new SampleSheet($pdf);
$sheet->setPoll($poll);
$sheet->generate();

$pdf->outputToFile(__DIR__ . '/output.pdf');
```

## Documentation

### Parties

Parties should be created using `PartyFactory`.
This has three methods:
* `createParty($name, $imagePath)` allows a party with a given name to be registered and allows an image path to be provided for the logo
* `getParty($name)` will get a party that has been created with that name and return it.
* `buildBaseParties()` is a convenience method that will call `createParty()` for all the parties included with library.

### Candidates

Candidates are created by constructing a new instance of `Candidate` which takes 3 parameters - `$surname`, `$firstNames` and `Party $party`.
There is currently no functionality to allow for Independents.
Pull requests welcome!

### Poll

To create a poll, first create an instance of `Poll`, giving it a `$description` and a `\DateTimeInterface $date`.
Once the poll has been created, add `Candidates` to it by calling `addCandidate(Candidate $candidate)`.

### Sample sheet

A sample sheet is created by instantiating `SampleSheet` with a `PDFInterface`.
Set the poll for the sample sheet by calling `setPoll(Poll $poll)` then call `generate()`

### PDFInterface

The `SampleSheet` takes a `PDFInterface` which is used to generate the PDF.
This is designed to allow any PDF provider to be used interchangeably.
Currently there is only one, FPDF, which is created as follows:

```php
$pdf = new FPDFAdapter(new FPDF());
```