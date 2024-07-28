<?php
/**
 * AdRelevantis functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package AdRelevantis
 * @since AdRelevantis 1.0
 */

/**
 * Register block styles.
 */

function themeslug_enqueue_script() {
    wp_enqueue_script( 'gam-v-1', 'https://www.googletagservices.com/tag/js/gpt.js', array(), false, array('strategy'  => 'defer',) );
    wp_enqueue_script( 'adr-v-1', 'https://www.adrelevantis.com/pub/prebid.js', array(), false, array('strategy'  => 'defer',) );
    wp_add_inline_script( 'adr-v-1',
'
var googletag = googletag || {};
googletag.cmd = googletag.cmd || [];
var PREBID_TIMEOUT = 3000;
var FAILSAFE_TIMEOUT = 6000;

var pbjs = pbjs || {};
pbjs.que = pbjs.que || [];

function bidFunc(keywrds, cats)
{
  //Keywords and IAB Categories of the content are sent as bidder parameters
  pbjs.que.push(function() {
    pbjs.setBidderConfig({
      bidders: [\'adrelevantis\'],
      config: {
        ortb2: {
          site: {
            keywords: keywrds,
            ext: {
			  data: {category: cats}
			}
          }
        }
      }
    });

	var adUnits = [
	{
	  code: \'div-adrhorizontal\',
	  mediaTypes: {
		native: {
		  sendTargetingKeys: false,
		  title: {
			required: true
		  },
		  image: {
			required: true
		  },
          clickUrl: {
            required: true
          },
		  sponsoredBy: {
			required: true
		  }
		}
	  },
	  bids: [{
		bidder: \'adrelevantis\',
		params: {
		  placementId: 13232354,
		  allowSmallerSizes: true,
		  cpm: 0.9
		}
	  }]
	},
	{
	  code: \'div-adrnatural\',
	  mediaTypes: {
		native: {
		  sendTargetingKeys: false,
		  title: {
			required: true
		  },
		  image: {
			required: true
		  },
          clickUrl: {
            required: true
          },
		  sponsoredBy: {
			required: true
		  }
		}
	  },
	  bids: [{
		bidder: \'adrelevantis\',
		params: {
		  placementId: 13232354,
		  allowSmallerSizes: true,
		  cpm: 0.9
		}
	  }]
	},
	{
	  code: \'div-adrsquare\',
	  mediaTypes: {
		native: {
		  sendTargetingKeys: false,
		  title: {
			required: true
		  },
		  image: {
			required: true
		  },
          clickUrl: {
            required: true
          },
		  sponsoredBy: {
			required: true
		  }
		}
	  },
	  bids: [{
		bidder: \'adrelevantis\',
		params: {
		  placementId: 13232354,
		  allowSmallerSizes: true,
		  cpm: 0.9
		}
	  }]
	},
	{
	  code: \'div-adrvertical\',
	  mediaTypes: {
		native: {
		  sendTargetingKeys: false,
		  title: {
			required: true
		  },
		  image: {
			required: true
		  },
          clickUrl: {
            required: true
          },
		  sponsoredBy: {
			required: true
		  }
		}
	  },
	  bids: [{
		bidder: \'adrelevantis\',
		params: {
		  placementId: 13232354,
		  allowSmallerSizes: true,
		  cpm: 0.9
		}
	  }]
	}/*,
	{
	  code: \'/21901351985/header-bid-tag-0\',
	  mediaTypes: {
		banner: {
		  sizes: [[728, 90]]
		}
	  },
	  bids: [{
		bidder: \'adrelevantis\',
		params: {
		  placementId: 13144370,
		  cpm: 0.50
		}
	  }]
	}
	*/];
	
	googletag.cmd.push(function() {
	  var slot1 = googletag.defineSlot(\'/21901351985/native_nature\', \'fluid\', \'div-adrnatural\').addService(googletag.pubads());
	  var slot1 = googletag.defineSlot(\'/21901351985/native_horizontal\', \'fluid\', \'div-adrhorizontal\').addService(googletag.pubads());
	  var slot1 = googletag.defineSlot(\'/21901351985/native_square\', \'fluid\', \'div-adrsquare\').addService(googletag.pubads());
	  var slot1 = googletag.defineSlot(\'/21901351985/native_vertical\', \'fluid\', \'div-adrvertical\').addService(googletag.pubads());
//	  var slot2 = googletag.defineSlot(\'/21901351985/header-bid-tag-0\', [[728, 90]], \'/21901351985/header-bid-tag-0\').addService(googletag.pubads());
	  googletag.pubads().disableInitialLoad();
	  googletag.pubads().enableSingleRequest();
	  googletag.enableServices();
	});

    pbjs.addAdUnits(adUnits);
    pbjs.requestBids({
      bidsBackHandler: initAdserver,
      timeout: PREBID_TIMEOUT
    });
  });

  function initAdserver(bids) {
    if (pbjs.initAdserverSet) return;
    
	googletag.cmd.push(function() {
      pbjs.que.push(function() {
        pbjs.setTargetingForGPTAsync();
        googletag.pubads().refresh();
      });
    });
	
    pbjs.initAdserverSet = true;
  }
  
  setTimeout(function(bids) {
    initAdserver(bids);
  }, FAILSAFE_TIMEOUT);
};

//Content-Driven Advertising needs access to content. So, wait DOMContentLoaded event to start the bid process
document.addEventListener("DOMContentLoaded", function(event){   
  //Content-Driven Advertising refers to individual pages
  //Set referrer to no-referrer-when-downgrade to ensure safety while providing page path
  if (document.querySelector(\'meta[name="referrer"]\') === null){
	var meta = document.createElement(\'meta\');
	meta.name = "referrer";
	meta.content = "no-referrer-when-downgrade";
	document.getElementsByTagName(\'head\')[0].appendChild(meta);
  }
  else {
	document.querySelector(\'meta[name="referrer"]\').content = "no-referrer-when-downgrade";
  }
  
  var q = document.getElementsByTagName(\'body\')[0].innerText;
  
  var pload = \'q=\' + encodeURIComponent(q);
  var h = new XMLHttpRequest();
  h.onreadystatechange = function () {
    if (4 === this.readyState) {
      if (200 === this.status) {
        var res = JSON.parse(this.responseText);
        if (res != null){
		  var cats = res["Category"];
		  var keywrds = res["Keyword"].replaceAll(/\|/g,",");
		  bidFunc(keywrds, cats)
		}
      }
    }
  };
  h.open("POST", "https://api.adrelevantis.com/getcatskeywords", true);
  h.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  h.send(pload)
});');
    // here you can enqueue more js / css files 
}

add_action( 'wp_enqueue_scripts', 'themeslug_enqueue_script' );

add_filter('the_content', 'add_incontent_adr');
function add_incontent_adr($content)
{   if(is_single()){
      $content_block = explode('<p>',$content);
      if(!empty($content_block[2]))
      {   $content_block[2] .= '<div id="div-adrsquare" style="width:25%;float:left;margin-right:15px !important;"></div>';
      }
      for($i=1;$i<count($content_block);$i++)
      {   $content_block[$i] = '<p>'.$content_block[$i];
      }
      $content = '<div id="div-adrnatural"></div><div id="div-adrvertical" style="width:25%;float:right;top:40px;margin-left:15px !important;"></div>' . implode('',$content_block);
   }
   return $content;   
}
