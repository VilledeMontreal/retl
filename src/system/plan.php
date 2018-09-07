<?php
namespace \retl\ETL;

use \retl\helpers\Paths;

/*
 -------------------------------------------------------------------------
 RETL library for reversible extract-transform-load data migration operations
 --------------------------------------------------------------------------
 @package   retl
 @author    Ville de Montréal
 @link      https://github.com/VilledeMontreal/retl
 @since     2018
 --------------------------------------------------------------------------
*/
/**
 * A RETL plan is a set of declarative instructions for transfering data from a list of data 
 * sources to a list of data destinations. Each source/destination may be single database table or
 * a single file, etc. Every source/destination must be given an alias name for identification
 * purposes (helps decouple plans from changes in sources and destinations connection info).
 *
 * The plan includes:
 *  - Connection information (except passwords) to both sources and destinations;
 *  - Data structures to expect from each source;
 *  - A sequence of transformation fonctions to produce one or multiple destination records
 *    (each destination record must be formatted for almost direct importation into a destination).
 *
 *    This is a serialised, declarative pipeline of functions. Functions are usually defined in a
 *    separate file, outside of the plan. Function must be readily callable.
 *  - A descriptions of data structures expected by each destination.
 *
 * Although a RETL plan expects data from multiple sources and outputs data to multiple
 * destinations, the input record (called a source record) is a single object representing all
 * source data and the output record (called a destination record) is a single object
 * representing all destination data. This simplifies function interfaces and the likes.
 */
class Plan
{
   
}
