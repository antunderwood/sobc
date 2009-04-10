# Perlfect Search configuration file
#$rcs = ' $Id: conf.pl,v 1.64 2003/02/24 21:10:16 daniel Exp $ ' ;

# NOTE: Whenever you change one of the options that's marked with [re-index]
# you need to run indexer.pl again to make the change take effect.

###########################################################################
### basic configuration
### You'll have to adapt these values if you didn't use setup.pl

# Where do you want the indexer to start on your disk?
# ** Note ** : If your files are generated dynamically (e.g. via PHP)
# you should set $HTTP_START_URL (see below), otherwise users
# will be able to see your pages' source code using the
# "highlight matches" link.
# [re-index]
$DOCUMENT_ROOT = '/home/southorg/public_html/';

# The base url of your site (normally that's the URL which
# corresponds to $DOCUMENT_ROOT).
$BASE_URL = 'http://www.southoxheybaptistchurch.org.uk';

# The url in which Perlfect Search is located (usually somewhere in cgi-bin/).
$CGIBIN = "/cgi-bin/search_new/";

# The full-path of the directory where Perlfect Search is installed.
$INSTALL_DIR = '/home/southorg/public_html/cgi-bin/search_new/';

# Only files with these extensions should be indexed (case-sensitive). 
# This is only relevant for file system indexing, when you index files via
# http you need to set @HTTP_CONTENT_TYPES instead. [re-index]
@EXT = ("php");

# If you do not have telnet/ssh access to the server that runs the script, you
# need to execute indexer.pl via CGI. Of course not everybody should be able
# to do that, so set a password with this option.
# ** Note ** : Only use this if absolutely necessary! Setting to "" disables 
# execution as a CGI, which is much more secure. Note that other people on
# your server can probably read this file and look up your password.
$INDEXER_CGI_PASSWORD = "tropshop";

###########################################################################
### http configuration
### You only need this if you want to index your pages via http

# Where you want the indexer to start via http. Leave empty if
# you want to index the files in the filesystem ($DOCUMENT_ROOT).
# ** WARNING **: Do not use for foreign servers! It might use too many
# resources on other people's servers. [re-index]
# example: $HTTP_START_URL = 'http://localhost/';
$HTTP_START_URL = '';

# The indexer might not notice if it runs into an endless loop. To void
# that, set this to the maximum number of pages that will be visited
# (this can be bigger than the number of pages indexed). [re-index]
$HTTP_MAX_PAGES = 100;

# The web server's document root. Normally that's the same as $DOCUMENT_ROOT,
# it differs if you're only using Perlfect Search on a subdirectory. [re-index]
$HTTP_SERVER_ROOT = $DOCUMENT_ROOT;

# Limit crawling to these URL pattern. This is an important setting so 
# the script doesn't run out of control. 
# ** WARNING **: The default ($HTTP_START_URL) should not be changed,
# otherwise you risk the script to crawl on remote servers. For example,
# the robots.txt file will only be used on the $HTTP_START_URL server!
# [re-index]
@HTTP_LIMIT_URLS = ($HTTP_START_URL);

# Comment this out if you want to ignore robots.txt (only do that if
# you really know what you are doing):
$ROBOT_AGENT = 'perlfectsearch';

# Should the indexer follow links that are commented out?
$HTTP_FOLLOW_COMMENT_LINKS = 1;

# Only if indexing via http: the content types to index. 
# Add 'application/msword' for for MS-Word, 
# 'application/pdf' for PDF. [re-index]
@HTTP_CONTENT_TYPES = ('text/html', 'text/plain');

# Set to 1 to get verbose output during indexing. [re-index]
$HTTP_DEBUG = 1;

###########################################################################
### advanced configuration
### You only need this if you want to adapt advanced features

# Programs that convert other formats to ascii text.
# The name of the file to be filtered is passed as FILENAME, and the command
# must print out ascii (or latin1) text.
# pdftotext is part of xpdf, available at
# http://www.foolabs.com/xpdf/download.html
# antiword is available at http://www.winfield.demon.nl/
# NOTE: You also have to set @EXT or @HTTP_CONTENT_TYPES accordingly.
# If there's a problem with pdftotext, try a new version or hand over
# the -raw option to pdftotext.
# [re-index]
%EXT_FILTER = (
	   "pdf" => "/usr/bin/pdftotext FILENAME -",
	   "doc" => "/usr/bin/antiword FILENAME"
);

# How many results should be shown per page.
$RESULTS_PER_PAGE = 5;

# Limit the number of results. 0 = no limit.
$MAX_RESULTS = 0;

# Enable the "highlight matches" feature that displays the original
# pages, but with the search terms highlighted. See the README on
# restrictions of this feature.
$HIGHLIGHT_MATCHES = 1;

# A "highlight matches" link does only work for HTML files, so only
# offer such a link for files with these suffixes.
# ** Note **: If $HTTP_START_URL is not set, the highlighting
# will load the file from disk so that the user might find
# passwords in the highlightes file! So don't set to include
# dynamic file, unless you are using $HTTP_START_URL.
@HIGHLIGHT_EXT = ("php");

# Perlfect Search can highlight the search terms in the matching
# document. These are the colors that will be used for the background
# of the terms (the browser must support CSS for this). If the last color 
# is used, the first one will be used again if there are still terms left.
@HIGHLIGHT_COLORS = ('#4fafea', '#e5b547', '#aaaaaa', '#ee77ee');

# Show the ranking in percent, with the first document = 100%.
$PERCENTAGE_RANKING = 1;

# Do you want to index numbers? If so set $INDEX_NUMBERS to 1. [re-index]
$INDEX_NUMBERS = 0;

# If you don't have enough memory, set this to 1. This will slow down 
# indexer.pl by a factor of about 2. Searching is not affected.
$LOW_MEMORY_INDEX = 1;

# How much of the document should be put in the index? With this option,
# the context of the match is shown on the results page. This only works
# if the match was in the first $CONTEXT_SIZE bytes of the document.
# Warning: Using this option will generate a very big index file.
# Set to 0 to disable, set to -1 for no limit. [re-index]
$CONTEXT_SIZE = 0;

# If $CONTEXT_SIZE is enabled, how many occurences of every term should be shown
# on the results page?
$CONTEXT_EXAMPLES = 2;

# If $CONTEXT_SIZE is enabled, how many words should be used to show the context
# of a term?
$CONTEXT_DESC_WORDS = 12;

# How many words should be used from the <BODY> of an html document as a 
# description for the document in case there is no <META description> tag 
# available and $CONTEXT_SIZE is 0. [re-index]
$DESC_WORDS = 25;

# The minimum length of a word. Any word of smaller size is not indexed. 
# [re-index]
$MINLENGTH = 3;

# If you have umlauts or accents etc. in your text, enable this.
# With this option accented characters will be indexed as the characters
# they are based on (e.g. è -> e, ü -> u), without this option they will
# be filtered out completely (you don't want that). [re-index]
$SPECIAL_CHARACTERS = 1;

# The largest acceptable word size. Reducing this saves space but decreases
# result accuracy. Setting the variable to 0 ignores stemming alltogether.
# [re-index]
$STEMCHARS = 0;

# Add URLs to the index, so one can search for them? Note that special
# characters will be ignored, just as in normal text. [re-index]
$INDEX_URLS = 0;

# You can completely ignore certain parts of your documents if you put these 
# HTML comments around them. [re-index]
$IGNORE_TEXT_START = '<!--ignore_perlfect_search-->';
$IGNORE_TEXT_END = '<!--/ignore_perlfect_search-->';

# The maximum length of <title> elements, everything longer than this
# will be cut off. [re-index]
$MAX_TITLE_LENGTH = 80;

# How much more important are words found in the title, in the meta values
# (author, description, keywords), and in the headlines compared to normal 
# text in the body? This influences the ranking of the results.
# Use any integer (0 = ignore that text completely) [re-index]
$TITLE_WEIGHT = 5;
$META_WEIGHT = 5;
$H_WEIGHT{'1'} = 5;	# headline <h1>...</h1>
$H_WEIGHT{'2'} = 4;
$H_WEIGHT{'3'} = 3;
$H_WEIGHT{'4'} = 1;
$H_WEIGHT{'5'} = 1;
$H_WEIGHT{'6'} = 1;	# headline <h6>...</h6>

# If you want to log the queries to an extra file, set this to 1.
# Every use of search.pl will then be logged to data/log.txt. That file
# has to exist and must be writable for the webserver. The line format is:
# REMOTE_HOST;date;terms;matches;current page;(time to search in seconds);
# NOTE: You'll have to comment in two lines at the top of search.pl to get the 
# time value (see the comment there).
# NOTE: if you have many queries, this file will grow quite fast.
$LOG = 0;

# This will increase the score of results that contain more than one of
# the searched terms. Queries with only one term will not be affected.
# The number given here is a factor that multiplies the score (even
# several times, if there are more than two terms). 0 turns it off.
$MULTIPLE_MATCH_BOOST = 0;

# Date format for the result page. %Y = year, %m = month, %d = day,
# %H = hour, %M = minute, %S = second. On a Unix system use 
# 'man strftime' to get a list of all possible options.
$DATE_FORMAT = "%Y-%m-%d";

# Date format for the "Latest Index update" information on the result page.
$INDEX_DATE_FORMAT = "%Y-%m-%d %H:%M";

# Directory with templates (normally you don't have to modify this).
$TEMPLATE_DIR = $INSTALL_DIR.'templates/';

# What's the default language. This is the language that's used if no lang
# parameter is passed to the script or if the parameter is invalid.
$DEFAULT_LANG = 'en';

# The result templates for several languages.
$SEARCH_TEMPLATE{'en'} = $TEMPLATE_DIR.'search.html';
$NO_MATCH_TEMPLATE{'en'} = $TEMPLATE_DIR.'no_match.html';
# This is the template for using search.pl via command line:
$SEARCH_TEMPLATE{'text'} = $TEMPLATE_DIR.'search.txt';
$NO_MATCH_TEMPLATE{'text'} = $TEMPLATE_DIR.'no_match.txt';
# This is the template for using the test cases (development only):
$SEARCH_TEMPLATE{'qa'} = $INSTALL_DIR.'qa/search_qa.txt';
$NO_MATCH_TEMPLATE{'qa'} = $INSTALL_DIR.'qa/no_match_qa.txt';

# The text for the "Next Page" link in several languages.
$NEXT_PAGE{'en'} = 'Next';
$NEXT_PAGE{'de'} = 'n&auml;chste Seite';
$NEXT_PAGE{'fr'} = 'Suivant';
$NEXT_PAGE{'it'} = 'Successiva';

# The text for the "Previous Page" link in several languages.
$PREV_PAGE{'en'} = 'Previous';
$PREV_PAGE{'de'} = 'vorige Seite';
$PREV_PAGE{'fr'} = 'Précédent';
$NEXT_PAGE{'it'} = 'Precedente';

# Text of the link that shows a colored backround for matched terms:
$HIGHLIGHT_TERMS{'en'} = 'highlight matches';

# The text for the "too common" warning. <WORDS> will be replaced with
# a list of the ignored words. If there are no ignored words, this text
# will not appear.
$IGNORED_WORDS{'en'} = '<p>The following words are either too short or very common and were
	not included in your search: <strong><WORDS></strong></p>';

###########################################################################
### You shouldn't have to edit anything below this line.

# Various paths (do NOT use system-wide /tmp for security reasons!)
$TMP_DIR  = $INSTALL_DIR.'temp/';
$DATA_DIR = $INSTALL_DIR.'data/';
$CONF_DIR = $INSTALL_DIR."conf/";
$STOPWORDS_FILE = $CONF_DIR.'stopwords.txt';
$NO_INDEX_FILE = $CONF_DIR.'no_index.txt';
$LOGFILE = $DATA_DIR.'log.txt';
$SEARCH = 'search.pl';
$SEARCH_URL = $CGIBIN.$SEARCH;
$UPDATE_FILE = $DATA_DIR.'update';

# Paths to the database files.
$INV_INDEX_DB_FILE = $DATA_DIR.'inv_index';
$DOCS_DB_FILE      = $DATA_DIR.'docs';
$URLS_DB_FILE      = $DATA_DIR.'urls';
$SIZES_DB_FILE     = $DATA_DIR.'sizes';
$TERMS_DB_FILE     = $DATA_DIR.'terms';
$DF_DB_FILE        = $DATA_DIR.'df';
$TF_DB_FILE        = $DATA_DIR.'tf';
$CONTENT_DB_FILE   = $DATA_DIR.'content';
$DESC_DB_FILE      = $DATA_DIR.'desc';
$TITLES_DB_FILE    = $DATA_DIR.'titles';
$DATES_DB_FILE     = $DATA_DIR.'dates';

# Paths to the temporary database files.
$INV_INDEX_TMP_DB_FILE = $DATA_DIR.'inv_index_tmp';
$DOCS_TMP_DB_FILE      = $DATA_DIR.'docs_tmp';
$URLS_TMP_DB_FILE      = $DATA_DIR.'urls_tmp';
$SIZES_TMP_DB_FILE     = $DATA_DIR.'sizes_tmp';
$TERMS_TMP_DB_FILE     = $DATA_DIR.'terms_tmp';
$CONTENT_TMP_DB_FILE   = $DATA_DIR.'content_tmp';
$DESC_TMP_DB_FILE      = $DATA_DIR.'desc_tmp';
$TITLES_TMP_DB_FILE    = $DATA_DIR.'titles_tmp';
$DATES_TMP_DB_FILE     = $DATA_DIR.'dates_tmp';

# Official version number.
$VERSION = "3.31b";
1;
