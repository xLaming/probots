<?php
date_default_timezone_set('UTC');
error_reporting(E_ALL);
ini_set("display_errors", 1);
#ini_set("log_errors", 1);
#ini_set("error_log", "/root/bot/log_errors.txt");
set_time_limit(0); // Cronjob::: sync && echo 3 | sudo tee /proc/sys/vm/drop_caches
class PROBots {
	public $packet, $login, $lastXML, $function, $translate, $sql, $sockets, $sep, $dir, $botID, $premiumBot, $csv, $sections, $satanBot, $started;
	public $done        = False;
	public $allreverse  = False;
	public $away        = False;
	public $typing      = False;
	public $gameRunning = False;
	public $cmdFolder   = '/root/bot/bot.php'; // Geniuns?
	public $ticked      = Array();
	public $latest      = Array();
	public $added       = Array();
	public $mysql       = Array();
	public $socket      = Array();
	public $times       = Array();
	public $userinfo    = Array();
	public $chatinfo    = Array();
	public $chatgp      = Array();
	public $commands    = Array();
	public $chatInfo    = Array();
	public $conn        = Array();
	public $config      = Array();
	public $botInfo     = Array();
	public $responses   = Array();
	public $users       = Array();
	public $alias       = Array();
	public $customs     = Array();
	public $notSend     = Array();
	public $settings    = Array();
	public $powers      = Array();
	public $xnDefault   = Array();
	public $pools       = Array();
	public $gameVar     = Array();
	public $hangman     = Array("abruptly","affix","askew","axiom","azure","bagpipes","bandwagon","banjo","bayou","bikini","blitz","bookworm","boxcar","boxful","buckaroo","buffalo","buffoon","cobweb","croquet","daiquiri","disavow","duplex","dwarves","equip","exodus","fishhook","fixable","foxglove","galaxy","galvanize","gazebo","gizmo","glowworm","guffaw","haiku","haphazard","hyphen","icebox","injury","ivory","ivy","jaundice","jawbreaker","jaywalk","jazzy","jigsaw","jiujitsu","jockey","jovial","joyful","juicy","jumbo","kazoo","keyhole","khaki","kilobyte","kiosk","kiwifruit","knapsack","larynx","luxury","marquis","megahertz","microwave","mystify","nightclub","nowadays","numbskull","ovary","oxidize","oxygen","pajama","peekaboo","pixel","pizazz","pneumonia","polka","quartz","quiz","rhubarb","rickshaw","schizophrenia","sphinx","squawk","subway","swivel","topaz","unknown","unworthy","unzip","uptown","vaporize","vodka","vortex","walkway","waltz","wavy","waxy","wheezy","whiskey","whomever","wimpy","wizard","woozy","xylophone","yachtsman","yippee","youthful","zephyr","zigzag","zilch","zodiac","zombie","abases","abductor","aberration","abrogate","absolutes","absorbency","absurd","abused","acacia","accelerates","accessible","accident","accidentally","acclaimed","acclimate","acclimatisation","accomplishments","accosts","accredited","accrued","acquaints","acquiescent","acreages","acrobatic","acrostics","acrylic","adaptable","adaptations","addicted","admits","adorable","adrenal","adulation","adventurer","aerosol","affirmatively","affirmed","afternoons","afterwards","aggregating","agnostics","agonize","agreeing","airless","airworthy","allergic","alphabetize","alright","alternatively","amalgams","amateurish","ambassadors","amenities","amidst","ampoules","amusements","anachronistically","analgesic","analysed","analysing","analysis","analyst","anecdotal","anesthetizing","angered","angioplasties","anglicisms","angoras","annihilate","annihilates","antagonises","antedated","anticipating","anticlimactic","antirrhinums","apologized","apotheoses","appall","appertains","appetizers","appraisals","appreciations","apprehended","apprehending","apprehensive","approved","arabesque","arcade","archaeological","archetypical","arraying","arrives","arrogance","arterial","ascetics","ascribes","asphalted","aspirate","assassinating","assenting","assents","assessing","assuage","asunder","asylum","atelier","atheists","attacking","attesting","attributing","auburn","audibility","audiovisual","authorship","autographing","autographs","automated","autopilots","available","avenge","avenged","averagely","averting","aviary","avionics","awakened","awkward","awoken","bagging","bagpipe","baguettes","bandleader","bandstand","baptisms","barbie","barefooted","barney","barneys","barometers","baronets","bartering","battering","batterings","batting","battleaxe","battlefields","bauxite","bazaar","beagles","beautiful","bedroom","bedsitter","beefsteaks","befitted","behaviour","behooves","belabors","belaying","believable","bellboy","bemoans","benighted","bequest","beseechingly","bespoke","bested","betrays","betrothed","betwixt","bibliography","bibliophiles","biggie","billboard","binning","birdbrains","birthplace","blackened","blackest","blacksmiths","blamed","blancmanges","blanket","blared","bleaching","blotched","blowups","blunted","blunter","boaters","bobbins","boltholes","bombard","bonnier","bonuses","boogied","bookable","bookbinding","bookmark","booksellers","bookworms","boosts","bootlace","bottoms","bouffant","brainstorm","breakfast","breakups","breaststroke","brigades","brightly","brings","briskly","broadcaster","broadens","brouhaha","brutal","brutality","brutally","buffalo","buffoons","bugbear","bullied","bullring","buoyantly","bureaucratic","burglaries","burgundies","busied","buzzword","caddied","cajole","calories","campaigner","campaigners","camping","canapes","cancels","canonise","canoodling","canvas","captain","captives","caramelise","caravanning","cardamoms","careering","carnation","carnations","carpeted","carting","casually","categorizing","ceding","celebratory","cenotaphs","censures","centerpiece","centiliter","centimetre","chainsaws","challenges","chamomile","chances","chapels","characterizations","characters","charades","chaser","chattered","cheapen","chickening","chickweed","chicory","childish","chilly","chintz","chivalrous","chloroform","choirboy","choppier","choppy","chopsticks","choral","christen","chromosomes","chronological","chubbier","chummed","circled","circlets","circularize","circumlocution","circumnavigating","civvies","classicists","cleaners","cleansing","cleanup","clerks","climatologist","climax","climaxes","climber","clinked","clitorises","clogged","clothes","cloudiest","cloying","clubbed","clumsy","clutching","coarsest","coccyxes","coerces","coffee","cognisant","coinages","coincidentally","collaborate","collarbone","collectivizing","collector","colloquial","colonisers","colonnade","colored","colourways","comedienne","commences","commentate","commentating","commercial","commercialism","commercials","commissary","commissioning","commonest","communist","compare","compere","compete","competent","compilation","compiles","complexions","composed","computerised","computes","conceitedly","conceived","concerted","conchies","conclusively","concoctions","concreted","concreting","conducted","confederations","confession","congratulations","congressman","conical","conjectures","connect","connubial","conquering","consents","consoled","consolidations","consort","conspicuousness","constantly","container","contention","contentment","contestants","contextualised","contextualises","continuance","contradiction","contraindications","contribution","controversial","conversations","conviction","convulsing","coolie","cooped","coordinating","copula","copycats","copywriter","coracles","coreligionists","corncobs","corncrake","cornstarch","correspondent","corrie","corroborative","corrupted","cosmopolitans","cossetting","cottages","cottoning","couchettes","cougar","counteracts","countless","courageously","courtliness","courtyard","cracker","crackers","craning","cranky","cranny","creakily","creakiness","creators","credit","crescent","crewed","criminalizes","criminalizing","crispness","crocks","crossbones","crosschecks","croupiers","crowded","crucifying","cruder","crumpet","crumple","crystallisation","crystallising","cumming","curacies","curliness","currant","cursive","curtseyed","cutouts","cyclical","cylinders","cypher","daises","dammit","damnable","danced","dastardly","dawdling","deafened","dearests","debates","debenture","debriefs","debunked","decanted","decanter","deception","decimates","decisiveness","decriminalize","dedication","deductions","defeatist","defeatists","defecate","deferment","define","deflates","deformity","defraud","defrosters","defrosting","dehumanising","deigning","deletions","delineating","delved","demand","democratisation","demographer","demolished","demoniacal","denationalizes","denial","denigrating","densely","denseness","denude","deodorising","deodorizing","departmental","dependants","depopulate","depress","depressurizes","depute","deranged","derbies","deregulation","descents","desegregation","desolated","despises","destabilizes","destroying","detain","detained","determinants","detestable","detoured","diadem","dialectical","dialectics","diatonic","diciest","dicker","dictatorially","digests","dilute","dingoes","disagreeably","disagreeing","disagreements","discernible","disciplinarians","discoloring","discomfited","discoverers","discredit","discreetly","discrimination","disembodied","disequilibrium","disguised","disgust","disillusioning","disincentive","disinheriting","disinterested","dislodges","disobey","disobeyed","disoriented","dispatches","dispersed","disposal","disprove","disregard","disrupts","dissembled","dissociation","distaste","distend","distinctions","distributorships","disturbing","disunited","dividends","divines","dizzying","dodders","dogleg","doglegs","dogmatist","dolling","dominions","donating","dormers","dormitories","doubts","downers","downgrading","downstairs","dowsing","drachmae","draconian","draftier","drained","drainpipe","dropper","droppings","droughts","drugstore","drumming","duplication","earthed","earthquake","economised","educates","effacing","efficiently","elaborately","elderberries","elected","electrically","electrodes","electromagnets","elision","eloped","elucidate","elucidating","embassy","embezzling","emboss","emergence","emperor","emperors","emptied","enables","encampments","enchanted","enchilada","encircling","encumbering","endeavored","endemic","endocrine","endurance","energies","enervated","enfold","enfolds","engagement","engineering","engraves","enhancers","enlightened","enormously","ensconces","enshrouds","enslaves","ensnare","entirety","entrenchments","epicentre","epidermis","epiphany","epistolary","equivocal","equivocations","eradicates","eroded","errors","escape","esoteric","espies","espying","essaying","ethical","ethnologically","evacuated","evaluated","evaluation","evasion","evicting","evilly","evocations","evolves","exacerbated","exactness","excavations","exchanged","exclaiming","exclude","exclusionary","excoriate","excreting","excusing","exhortations","exigency","expectation","expects","experts","expiates","expiring","explored","explorers","expostulation","extends","exterminates","externalised","externalizes","extinct","extolling","extradites","extraterrestrial","eyeful","eyeing","eyeliner","facelift","facilitates","faffed","faintest","fairyland","faithlessly","falsifications","familiarize","fanatic","fanaticism","fandangos","fantasise","fanzines","farmhouses","fascists","fatigues","favored","favorite","favourite","fazing","featherbrained","feeblest","feeder","feelgood","feints","ferociousness","fibulae","fictionalisation","fictionalisations","fidgets","finales","finder","finders","finesses","firmer","fishermen","fishiest","fissures","fitment","fitters","fjords","flagellate","flagellation","flapjacks","flautists","flavouring","flicker","flightier","flosses","flotillas","flounce","flouncing","flunkeys","fluoridating","fodder","folders","footsteps","footstools","forays","forbearance","forewarns","forking","formalizing","formals","forsythias","fractals","frames","franchisee","fraternises","fraudulent","freakiest","freebooter","freighted","frenzy","freshening","fresher","fretting","frizzy","frontiersmen","frugally","frumpiest","fuelled","fulfilled","fulness","functionalists","funiculars","furnished","fusilier","futurists","futurity","gadgets","gallivanted","gallon","gambols","gamekeeper","gangsta","garcons","gardens","gasolene","gatecrashes","gaudily","gawking","generates","genial","genning","gentrification","germinating","ghettoizing","gimmick","glamor","glassful","glaziers","globalizing","globetrotters","gloves","glowering","gluttony","goatherd","godless","godmother","godson","goldfinch","golfing","gooiest","gooseberries","gooseflesh","gorgeous","grabby","gramophone","gramophones","grandads","granular","graphite","grapnel","grasses","graters","gratins","greats","greenfield","greenhouse","griddle","grouch","groundskeeper","groundskeepers","growls","guarantees","guesswork","gunnels","gynecologist","habitable","hacking","hairiest","hairline","handguns","handkerchiefs","handrails","hangdog","happens","happiest","harbor","harbour","harboured","hardwood","harlequins","harnesses","harpsichord","hashing","hastens","hatbox","hatter","haulage","haulier","hawkers","headache","headers","headhunt","headhunted","headmistress","health","heartaches","hearthrugs","hemorrhaging","hesitations","heuristic","hideous","hideout","hinted","hippos","hitched","hitches","hitchhikers","holidaymakers","homburg","homeopathic","homesteading","homeworker","homogenising","honchos","honeysuckle","hoodwink","horses","horticultural","hotplates","housemasters","housemistress","housewarmings","housewifely","hugging","humanises","humbug","hummock","humored","humpback","hunkering","hurricane","husbandry","hydrates","hyperventilated","iambic","idealistic","identikit","idolizes","ignitions","illuminate","illusory","imagining","imbued","immunizes","immure","imparted","impasse","impassivity","impersonated","implanting","implosions","importers","impound","impoverishment","improvement","impudence","impulsiveness","impure","inactivity","inamorata","incapacitate","incarnates","inclusions","incongruities","inconspicuously","increased","incremental","incubated","incurious","indebted","indemnities","indies","indoctrinate","indoctrinates","indubitably","inductees","industrialisation","inexpedient","inexpensively","inferior","infiltrator","informally","ingested","ingrowing","inhibited","inklings","inmate","innuendos","inoculation","inpatients","inputted","inquiring","inquisition","insipid","insisted","insisting","inspects","insteps","instigates","instills","insured","intellectualism","intense","interbreeding","interchangeable","interconnected","interesting","interfere","interlaced","intermediates","interned","interpreted","interwove","intestine","intrinsically","introspection","inventor","investitures","invigorating","ionosphere","ironmongery","irradiated","irreparably","irreproachable","issues","itemise","itemised","jackasses","jackhammers","jaguar","jammed","jangles","javelins","jazzing","jealously","jeopardising","jesting","jettisons","jewelers","journo","joylessness","jubilant","juntas","justices","keepsakes","kennels","kenning","keyboard","kingmaker","kinkiest","kinship","kneecaps","knocker","knockers","laborer","lacerate","lactic","lampreys","landholder","landscapes","larkspurs","laughably","launcher","laundry","laxest","layover","laziest","leaned","leaseback","leering","legible","legislates","legitimises","lessons","letting","levitated","liberal","liberalize","liberator","licences","lieutenant","likely","lionizing","lipstick","liquidized","listenable","livened","loafer","lollop","lovable","lucked","luggage","lugubrious","lugubriously","luncheonette","lychgate","mackerel","madams","maggot","magnets","magnolia","maidens","mainsails","majorette","majority","makeweights","malfunction","malfunctioned","mammogram","manacles","managed","manana","manipulating","manpower","mansards","margarine","marginalisation","marginalizing","marketeer","marking","maroon","marquesses","marshland","marten","martinis","masculinity","matricide","maximize","mayoral","maypoles","meandered","meanness","medicinal","melodrama","melodramatic","member","memoranda","mentors","mercilessly","merino","mescalin","mesmerizing","metabolise","metabolisms","meters","microwaveable","miffed","mileometer","mileometers","millipede","milometer","minarets","minestrone","miniaturises","mirages","miscarriages","misconstrued","miscreants","misdirected","miserly","misjudged","mislead","misogynistic","mispronounces","mistaking","mistress","misunderstanding","mobilise","mockingbirds","modeled","moderate","moderators","moisturizers","moisturizes","molecule","mollycoddle","mollycoddles","molten","monolith","monoplanes","monopolised","monotone","monotonous","monotonously","moonlit","moping","mordantly","morphs","mortice","motorists","mounds","mountaintop","mouthwash","mulberries","mulching","mullahs","multiplexes","multiplies","mundane","munificent","murders","murkier","musher","musicians","mussel","mustang","mustering","mutilating","mutilations","mutuality","mutually","nailing","narcoleptic","narration","national","nauseous","neater","necklace","neckties","needier","nefarious","negate","neglect","neighing","nepotism","neurologist","newspaperman","nimbler","nipple","nitrogen","nitwits","normalise","northbound","nutcrackers","nuttiest","nymphet","oarsmen","oarswoman","oatcakes","obedient","objectively","objects","obligation","obliging","obliteration","oblivious","observatories","obsessions","obstructions","occupying","offertories","offertory","officiating","officiousness","offload","offside","omelet","omission","ontology","opaquely","opener","operable","operations","oppression","oppressor","optimise","optimises","optimum","oratory","ordinariness","ordnance","organisation","organisms","organizing","orthodoxies","oscillators","otters","outbreaks","outcries","outmaneuver","outrages","outweighed","overacted","overbalances","overcomes","overeating","overestimated","overladen","overprotective","overreached","overreacted","overruling","overshadowed","oversleeps","overspends","overtake","overtaxes","overtaxing","overturn","overvaluation","overwriting","oxidation","oxidizes","padding","pageant","paginates","painters","paired","paleontologists","palpates","panhandler","panorama","pantechnicons","papayas","paracetamols","paramedical","paramedics","paranoids","paratrooper","pardoned","parishioners","parities","parody","partaken","partaking","participles","particularity","parting","partitioned","partridge","passivised","password","pasteurizing","patches","patching","patriots","patronesses","patronized","patters","pausing","payroll","payslips","peccadillos","peevishness","peewee","pellucid","penalise","penciled","perfectionists","performances","performer","permissions","personages","personifications","pervasively","peskiest","petrodollars","petticoat","pharmacopoeias","pheasant","phenom","philological","phlegm","photoelectric","photostatted","physical","physiognomies","physiology","physios","physiotherapists","piazza","pickaxe","pickiest","pickled","pickling","picnickers","piffling","pigpens","pimientos","pinholes","pinnies","pioneered","piousness","pirouetted","pirouetting","pitching","pitiless","plaintive","plantings","platitude","playthings","pleadingly","pledges","plummets","plumping","plundering","plunge","pockmark","pokier","polarized","policed","politic","politics","polity","pollster","polygamy","polyglot","polymaths","polysemous","poncho","poncing","ponied","poppets","portions","portrayals","poseur","posher","possessors","postboxes","posters","postmark","postseason","postulated","potent","powders","practiced","practices","pranksters","prattle","preaching","preambles","precedence","precepts","predestination","predictors","preferring","premenstrual","premise","prepacked","prerequisites","prescient","prescribed","presents","president","presidents","presumes","prettifies","prevaricate","prided","primes","princes","printout","prioritise","prisoners","prissier","privacy","prizewinning","problem","proclivity","procreating","produce","professionalize","profundity","progressing","progressions","prolific","prominently","promises","promising","prompters","pronounce","prophecy","proposers","propounded","proprietresses","prosecutions","prostrated","protesting","protrusions","proudest","proviso","pruning","pseudonym","psychoses","psychotherapist","psychotherapists","publication","publicises","puddles","pulpits","pulsing","pummeled","pumped","pumpkin","puppies","purchaser","purchasers","pursers","purveys","pusillanimous","puzzle","pyramid","pyromaniac","quadruples","qualms","quarreled","quashes","question","questioningly","quicken","quicksilver","quieten","quintet","quirkier","quizzical","quotient","qwerty","rabbited","racketeer","radiance","ramblings","ramshackle","rangefinders","rangers","raping","rarely","raspberry","ratchet","ratcheted","rationalises","ratting","reactionaries","realized","reasserts","rebelliousness","recant","recapitulation","recaps","recharged","recognized","reconciliation","reconvene","record","records","recriminatory","rectitude","recycling","redoes","redounding","redresses","referencing","reflections","reflexive","reflexology","refurbishes","refusals","regarding","regards","regents","regretful","rehearse","rehoused","reiterates","relapse","relaunching","relies","religions","reloaded","relocated","remarriages","remaster","rematch","reminding","remodelling","remolding","repenting","repetitively","replicate","repressing","reprint","reproached","reproves","reruns","rescues","resemble","reserve","resettles","resonated","resounds","respired","resplendence","restarting","restocked","restraints","resurfaces","retrenches","retrogression","retrospective","returnable","returning","reusable","reverential","reversals","reversibility","revisionist","revisions","revivalist","revolted","revolutions","revolving","rewires","rhinestone","rhymes","rickets","ricocheted","ridges","rigged","rightist","ringlet","robbed","rocketing","rocking","rococo","rolling","rostra","rostrum","rouses","rowdily","rubber","rubbers","ruinous","rumbles","rumination","rumpled","runways","rushing","saboteurs","sackful","sackings","sacrilegious","sacristy","salamander","salesclerks","salvoes","samosa","sampans","samples","sanctioning","sandbank","sandpit","sarcophagus","satisfactorily","satisfies","savageries","savages","saving","scales","scamper","scandalous","scapegoating","scarabs","scarpering","scenarios","schnook","scholarly","schoolmarmish","schoolyard","scolding","scorching","scratches","screwed","scribbling","scrimped","scrolls","scrounging","scruffiness","scruple","scudded","scuppered","seamier","searchers","secure","seesawing","segments","seizures","senators","sensor","sententious","sentimentalises","sequentially","series","sermonised","sermonize","serviced","setsquare","seventeenths","severally","shallots","shattering","shavers","sheathe","shebeens","sheepishness","shelling","shepherding","shibboleths","shinned","shipment","shipped","shippers","shortage","shortbread","shorthanded","shorty","showdowns","shrink","shrinking","shrubs","shutdowns","sickens","sidekick","signposting","silvan","simplifications","singed","singulars","sinister","sisterhood","skateboarder","skater","skewer","skimps","skyjack","skyrocketing","slagged","slammed","slappers","slaughter","slaughtering","slavery","sleepiness","slipways","slouches","slowdown","smacking","smiling","smoothness","smugly","smuttiest","snooper","snooty","snorkelling","snowmobile","snuffed","sociables","socials","sociologically","softback","softens","solicitors","sombrero","something","songster","songwriter","soothingly","sophomore","sorrowful","sorrows","spacewoman","spammed","spankings","spareribs","sparring","speedometer","sphincters","sphinx","spiciness","spindly","spinneys","splattered","spluttered","spookier","spotters","spouts","sprayers","spraying","springing","spurted","sputters","squirreled","stabbing","stablemen","staffers","stains","stairwell","stalled","stance","stanch","standardisation","starchiest","stares","starlings","starter","statesmen","staunching","staving","steamed","steeplejacks","stepchild","stereo","stereotypes","stickier","stickleback","stilted","stockbroking","straddles","stranglers","strategy","strictest","strives","strongmen","studious","stuffily","stumps","stunting","sturdiest","subcutaneously","subdue","subduing","subjectivity","subordination","substantially","substitutes","subtotals","subversively","suction","suctions","suffocation","suffrage","suggestible","sullied","sultana","sunblock","sundae","sundials","sunglasses","superconductor","supersedes","superstar","superstitious","superstructure","suppository","suppurated","sureness","surrounded","susceptibilities","suspecting","susses","suzerainty","swaddled","swamps","swearing","sweatbands","sweatpants","sweatsuits","sweetmeats","swiftly","swirling","switched","swivelled","swooning","sycophantic","symbolises","symposia","synchronizing","syndicalists","syphons","systematically","tableware","tackled","tackling","tactlessness","tadpole","tailcoat","tailpieces","tailpipe","takeaway","takings","tamoxifen","tangerines","tantalised","tantalize","tapirs","tappets","tardier","tarmac","tautens","taxicab","teachers","tearaways","teasel","teaspoon","teazle","technicalities","technicality","technologies","technologists","teemed","teepee","teetotal","tellies","temporising","tenaciously","tenants","tepees","termites","terrier","tester","testicular","testily","testimonial","theocratic","thicken","thickeners","thingummy","thistles","thrill","thrive","throatily","thronged","thunders","tickled","tickles","tidiest","tidying","tiebreak","tiebreaker","timeliest","timetables","timidly","tinder","tinkers","tinkling","tiresome","tissue","toadied","toastmaster","toboggan","tonier","toothy","topographically","topples","torpedo","torturers","toting","touchlines","traced","tracers","tracheas","trackball","trafficked","trainspotting","transcendental","transfixed","transience","transistor","transitives","translator","translators","transliterations","transmogrifies","transparent","trappings","traumatizes","trembles","trendsetter","triangular","triangulation","tribunals","trickle","tridents","trinkets","truces","truncheons","trunks","trussed","trying","tumbles","turbocharges","tussling","typing","umlaut","umpire","umpiring","unarguable","unattached","unbiased","unchanging","uncompromising","unconsidered","underachievement","undercharge","underdone","underestimating","undergone","undergrowth","underpass","underscoring","undersells","undersized","understate","underwater","undisciplined","undressed","unequaled","unfathomable","unfavourable","unforeseeable","unhitch","uniformity","unisex","unloads","unmolested","unpredictable","unprotected","unravel","unrelieved","unrelievedly","unremitting","unscramble","unscrambling","unscrewed","unsophisticated","unstructured","unsuitable","untangle","untutored","unwraps","upstairs","uselessly","ushered","usurpation","utilised","utilized","uttered","vacancy","vaccinating","vacuuming","vagueness","vandalised","vantage","vaporization","variant","vaulted","vegetarian","vegges","veggieburger","ventriloquist","verbalised","verbatim","versos","veterinary","vibrators","victims","videophones","videotape","videotapes","vigils","villainy","violincellos","virgin","viscera","visitation","vitiates","vocabulary","volumes","vouchsafe","wainscots","waiting","waltzed","wanderer","wanderers","wapiti","warped","warthog","waster","wastrels","waterfowl","waterproofing","wattle","waylays","weatherman","wedding","weedkiller","weekend","weevil","weighbridges","weirdest","welches","wellness","westernise","whales","wheelies","wheezy","wherewithal","whined","whiskies","whitewashed","wholesalers","wildcatter","wildest","winched","wisterias","withdrawn","wobble","wobbles","womanise","woodsy","workings","workshops","worldliness","worrywart","worsened","worsens","wreaths","wrinklies","writhes","wronging","xenophobia","yachting","yachts","yakking","yodels","youngish","zillions","zonked");
	public $adminIDs    = Array(956544769, 10000038);
	public $helperIDs   = Array(956544769, 10000038, 356597676, 206159116, 34000000);
	public $specialBots = Array(1, 2, 3);
	
	public function __construct($botid, $debug) {
		$this->dir = __DIR__;
		$this->sep = DIRECTORY_SEPARATOR;
		$this->debug = !Empty($debug) && $debug > 0 ? True : False;
		$settings = parse_ini_file("_config_/config.ini");
		Foreach($settings AS $s => $x)
			$this->account[$s] = $x;
		$mysql = parse_ini_file("_config_/mysql.ini");
		Foreach($mysql AS $s => $x)
			$this->mysql[$s] = $x;
		Foreach(glob($this->dir . $this->sep . 'class' . $this->sep . '*.php') AS $classes) 
			require_once($classes);
		$this->function = new Functions($this);
		$this->sockets = new Sockets($this, $this->function);
		$this->sql = new Database($this->mysql["host"], $this->mysql["user"], $this->mysql["pass"], $this->mysql["db"]);
		$getVars = $this->sql->fetch_array("SELECT * FROM `accounts` WHERE `id`='{$botid}' LIMIT 1");
		$this->botInfo = $getVars[0];
		$this->times["freezed"]          = $getVars[0]["freezed"];
		$this->times["subscription"]     = $getVars[0]["subscription"];
		$this->config["snitch_list"]     = (Array) json_decode($getVars[0]["snitch_list"]);
		$this->config["friend_alert"]    = (Array) json_decode($getVars[0]["friend_alert"]);
		$this->config["disabled_powers"] = (Array) json_decode($getVars[0]["disabled_powers"]);
		$this->config["allowedlist"]     = (Array) json_decode($getVars[0]["allowedlist"]);
		$this->config["filters"]         = (Array) json_decode($getVars[0]["filters"]);
		$this->config["trusted"]         = (Array) json_decode($getVars[0]["trusted"]);
		$this->config["moderation"]      = (Array) json_decode($getVars[0]["moderation"]);
		$this->config["l_whitelist"]     = (Array) json_decode($getVars[0]["l_whitelist"]);
		$this->config["l_blacklist"]     = (Array) json_decode($getVars[0]["l_blacklist"]);
		$this->config["badwords"]        = (Array) json_decode($getVars[0]["badwords"]);
		$this->config["minrank"]         = (Array) json_decode($getVars[0]["minrank"]);
		$this->config["alias"]           = (Array) json_decode($getVars[0]["alias"]);
		If(!Isset($getVars[0]["chat"])) { $this->function->trace("You need setup chat name.", 4); }
		$getC = @json_decode($this->function->getFiles('http://xat.com/web_gear/chat/roomid.php?v2&d='.(is_numeric($getVars[0]["chat"]) ? "xat".$getVars[0]["chat"] : $getVars[0]["chat"])), True);
		$this->roomInfo["id"] = $getC['id'];
		$this->roomInfo["name"] = $getC['g'];
		$this->roomInfo["desc"] = (!Empty($getC['d']) && $getC['d'] != '\\u00A0' ? $getC['d'] : 'Inexistant');
		If(Empty($this->roomInfo["id"])) { $this->function->trace("Chat not found.", 4); }
		$this->botID = $botid;
		$this->conn["ip"] = $this->function->getIP();
		$this->conn["port"] = $this->function->getPort();
		/* Load plugins */
		$this->loadConf('defaultnames');
		$this->loadConf('commands');
		$this->loadConf('responses');
		$this->loadConf('customcmd');
		$this->loadConf('csv');
		$this->loadConf('freetime');
		/* Load custom translation */
		$this->translate = new Translations($this, $getVars[0]["translations"], $this->botInfo["language"]);
		/* Unset sometings */
		unset($getVars, $getC);
		/* Load powers */
		$this->function->loadPowers();
		/* Bot/Site Settings */
		$getVars = $this->sql->fetch_array("SELECT * FROM `settings` WHERE `index`='1' LIMIT 1");
		$this->settings = $getVars[0];
		/* Load Bot Api */
		$this->config["api"]  = Array("ip" => "127.0.0.1", "port" => "1" . getmypid(), "key" => substr(md5(time()), 0, 9));
		$this->botInfo["pid"] = getmypid();
		$this->refreshBot("api");
		$this->refreshBot("pid");
		/* Read all */
		$this->sockets->connectServerBind(0, $this->config["api"]["port"]);
		$this->sockets->connect();
		$this->joinRoom($this->roomInfo["id"]);
		$this->sockets->read();
	}
	
	public function __call($function, $args) {
        If(in_array($function, $this->functions))
			return call_user_func_array($funct, $args);
        Else
			throw new Exception("Unknown function: '{$funct}'");
    }
	
	public function login($force=False) {
		If($this->settings["logindate"] <= time() || $force == True) { // relogin 15min
			#$xSock = fsockopen($this->conn["ip"], 10000);
			$xSock = fsockopen($this->conn["ip"], 80);
			fwrite($xSock, '<y r="8" v="0" u="0" />'.chr(0));
			fread($xSock, 1024);
			fwrite($xSock, '<v p="'.$this->account["pass"].'" n="'.$this->account["user"].'" />'.chr(0)); 
			$recv = fread($xSock, 1024);
			fclose($xSock);
			$this->xmlArray($recv);
			$this->sql->query("UPDATE `settings` SET `logindate` = '" . strtotime("+3 minutes") . "', `logincache` = '" . json_encode($this->login) . "' WHERE `index` = '1';");
		} Else {
			$this->login = json_decode($this->settings["logincache"], True);
		}
		$this->botInfo['bank'] = Array("xats" => Isset($this->login['dx']) ? $this->login['dx'] : 0, "days" => @floor(($this->login['d1'] - time()) / 60 / 60 / 24));
		If($this->botInfo['bank']['days'] < 1) { $this->botInfo['bank']['days'] = 0; }
	}
	
	public function joinRoom($chat, $login=False, $powers=Array(), $disabled=Array()) {
		If($login == True)
			$this->login(True);
		Else
			$this->login();
		$packetToSend = $this->function->createPacket('y', Array('r' => $chat, 'm' => 1, 'v' => 0, 'u' => $this->login['i']));
		$this->sockets->send($packetToSend);
		unset($packetToSend);
		$this->xmlArray(socket_read($this->socket[1], 2048));
		$j2 = $this->function->createPacket('j2', Array(
			'cb'       => $this->packet['y']['cb'],
			'q'        => '1',
			'y'        => $this->packet['y']['i'],
			'k'        => $this->login['k1'],
			'k3'       => $this->login['k3'],
			'd1'       => Isset($this->login['d1']) ? $this->login['d1'] : False,
			'z'        => Isset($this->login['z']) ? $this->login['z'] : False,
			'p'        => Isset($this->login['p']) ? $this->login['p'] : '0',
			'c'        => $chat,
			'b'        => Isset($this->login['b']) ? $this->login['b'] : False,
			'r'        => !Empty($this->botInfo['chatpass']) && is_string($this->botInfo['chatpass']) ? $this->botInfo['chatpass'] : False,
			'f'        => !Empty($this->botInfo['chatpass']) && is_string($this->botInfo['chatpass']) ? 6 : 0,
			'e'        => !Empty($this->botInfo['chatpass']) && is_string($this->botInfo['chatpass']) ? 1 : False,
			'u'        => $this->login['i'],
			'disabled' => '',
			'd0'       => Isset($this->login['d0']) ? $this->login['d0'] : False,
			'powers'  => '',
			'dO'       => Isset($this->login['dO']) ? $this->login['dO'] : False,
			'sn'       => Isset($this->login['sn']) ? $this->login['sn'] : False,
			'dx'       => Isset($this->login['dx']) ? $this->login['dx'] : False,
			'dt'       => Isset($this->login['dt']) ? $this->login['dt'] : False,
			'N'        => $this->account["user"],
			'n'        => ($this->config['filters']['stealth'] == 1 ? '$' : "").str_replace(' ', ' ', $this->function->protection(($this->botInfo['nick'])."(glow#{$this->botInfo['nameglow']}#{$this->botInfo['namecolor']})(hat#{$this->botInfo['hatcode']}#{$this->botInfo['hatcolor']})##{$this->botInfo['status']}#{$this->botInfo['statusglow']}#".$this->botInfo['statuscolor'])),
			'a'        => $this->function->protection($this->botInfo['avatar'])."#".$this->function->protection($this->botInfo['pcback']),
			'h'        => $this->function->protection($this->botInfo['homepage']),
			'v'        => !Empty($this->botInfo['chatpass']) && is_string($this->botInfo['chatpass']) ? 3 : 0
		));
		/* Get powers section */
		For($x = 2; $x <= 20; $x++) {
			If(Isset($this->login['d'.$x]))
				$powers[0][] = "d{$x}=\"{$this->login['d'.$x]}\"";
		}
		$disable = '';
		/* Get disabled powers */
		Foreach($this->config['disabled_powers'] AS $p) {
			$power = $this->function->pSub($p);
			$powers[1]['m'.$power[1]] = Isset($powers[1]['m'.$power[1]]) ? $powers[1]['m'.$power[1]] + $power[0] : $power[0];
		}
		Foreach($powers[1] AS $id => $p)
			$disable .= $id."=\"{$p}\" ";
		$this->sockets->send(str_replace(Array("powers=\"\"", "disabled=\"\""), Array(implode(' ', $powers[0]), $disable), $j2));
		#sleep(0.89); // I cant spam xat servers
		#$this->sockets->send("<w0/>");
		If($this->satanBot == True)
			$this->sockets->send($this->function->createPacket('x', Array('i' => 6, 'u' => $this->login['i'], 't' => 'AQA=')));
		unset($this->packet);
	}
	
	public function refreshBot($var) {
		$v = strtolower($var);
		Switch($v) {
			case 'responses':
				unset($this->responses);
				$getResp = $this->sql->fetch_array("SELECT * FROM `responses` WHERE `botid`='{$this->botID}';");
				Foreach($getResp AS $r)
					$this->responses[$r['word']] = $r['response'];	
			break;
			
			case 'disabled_powers':
			case 'snitch_list':
			case 'l_whitelist':
			case 'l_blacklist':
			case 'allowedlist':
			case 'moderation':
			case 'badwords':
			case 'minrank':
			case 'filters':
			case 'trusted':
			case 'alias':
			case 'api':
				$this->sql->query("UPDATE `accounts` SET `{$var}` = '".json_encode($this->config[$var])."' WHERE `id` = '{$this->botID}';");
			break;
			
			default: 	
				$this->sql->query("UPDATE `accounts` SET `{$var}` = '{$this->botInfo[$var]}' WHERE `id` = '{$this->botID}';");
			break;
		}
	}
	
	public function loadConf($type) {
		$t = strtolower($type);
		Switch($t) {
			case 'commands':
				Foreach(glob($this->dir.$this->sep.'commands'.$this->sep.'*.php') AS $cmd)  {
					require_once($cmd);
					$name = substr($cmd, strrpos($cmd, $this->sep) + 1, -4);
					$alias = array_merge(array_key_exists($name, $this->config["alias"]) ? $this->config["alias"][$name] : Array(), $alias);
					Foreach($alias AS $u) {
						$this->commands[strtolower($u)] = &$this->commands[$name];
						$this->alias[strtolower($u)]	= $name;
					}
				}
			break;
			
			case 'freetime':
				If(in_array($this->botID, $this->specialBots)) { // Official chat
					$this->times['subscription'] = 0;
					$this->times['special'] = True;
					$this->times['freezed'] = 0;
					$this->premiumBot = True;
				} Else {
					$archive = file_get_contents($this->dir.$this->sep.'cache'.$this->sep.'wiki'.$this->sep.'special_chats.txt'); // Check special_chats
					$chatList = Array();
					preg_match_all('@<a rel="nofollow" class="external text" href="http://xat.com/(.*?)">(.*?)</a>@i', $archive, $chats);
					Foreach($chats[1] AS $c) { $chatList[] .= strtolower($c); }
					If(in_array(strtolower($this->roomInfo["name"]), $chatList)) {
						$this->times['subscription'] = 0;
						$this->times['special'] = True;
						$this->times['freezed'] = 0;
						$this->premiumBot = True;
					}
					
					$json = json_decode($this->function->getFiles("http://xat.com/json/promo.php?t".time()), True); // Check chats promoted
					$promoted = call_user_func_array('array_merge', $json);
					Foreach($promoted AS $i => $c) {
						If(strtolower($c["n"]) == strtolower($this->roomInfo["name"])) {
							var_dump($c["t"]);
							$this->times['subscription'] = strtotime("+".($c["t"] - time() - 10800)." seconds");
							$this->times['freezed'] = 0;
							$this->times['special'] = False;
							$this->times['promoted'] = True;
							$this->premiumBot = True;
						}		
					}

					unset($promoted, $chatList, $archive, $json, $chats); // Speed :c
					
					If($this->times['freezed'] > 0 && $this->premiumBot == False) { // Check bot time
						$this->times['subscription'] = strtotime("+{$this->times['freezed']} seconds");
						$this->sql->query("UPDATE `accounts` SET `subscription` = '{$this->times['subscription']}', `freezed`= '0' WHERE `id` = '{$this->botID}';");
						$this->times['freezed'] = 0;
						$this->times['special'] = False;
						$this->premiumBot = True;
					}
					If($this->times['subscription'] < time() && @$this->times['special'] == False) {
						$this->premiumBot = False;
						$this->satanBot = True;
						$this->times['special'] = False;
						$this->botInfo['homepage'] = 'PROBots_Free_Version';
						$allpowers = $this->sql->fetch_array("SELECT * FROM `powers`");
						Foreach($allpowers AS $p) {
							If(!in_array($p['pid'], $this->config['disabled_powers']))
								Array_push($this->config['disabled_powers'], $p['pid']);
						}
					}

				}
			break;
			
			case 'responses':
				$getResp = $this->sql->fetch_array("SELECT * FROM `responses` WHERE `botid`='{$this->botID}'");
				Foreach($getResp AS $r)
					$this->responses[$r['word']] = $r['response'];
			break;
			
			case 'csv':
				$this->csv = file_get_contents($this->dir.$this->sep.'cache'.$this->sep.'fairtrade.txt');
			break;
			
			case 'defaultnames':
				$nicks = file_get_contents($this->dir.$this->sep.'cache'.$this->sep.'nicks.txt');
				Foreach(explode("\r",str_replace("\n", "", $nicks)) AS $v)
					$this->xnDefault[] = $v;
				unset($nicks);
			break;
			
			case 'customcmd':
				$getCmd = $this->sql->fetch_array("SELECT * FROM `custom_cmd` WHERE `botid`='{$this->botID}'");
				Foreach($getCmd AS $c)
					$this->customs[$c['command']] = $c['response'];
			break;
		}
	}
	
	public function xmlArray($packetOld, $type='') {
		If(strpos($packetOld, "<done") !== False){
			$this->done = True;
			$this->started = time();
		}
		$newArray = (Array) @simplexml_load_string($packetOld);
		Foreach($newArray AS $x => $value) {
			If(is_array($value)) {
				Foreach($value AS $p => $values) {
					$type = $this->function->expl0de($packetOld, '<', ' ');
					$packet[trim($p)] = $values;
					$this->packet[trim($type)][trim($p)] = $values;
				}
			}
		}
		If(file_exists($this->dir . $this->sep . 'packets' . $this->sep . strtolower($type) . '.packet.php'))
			include($this->dir . $this->sep . 'packets' . $this->sep . strtolower($type) . '.packet.php');
	}
	
	public function xmlArrayApi($packetOld, $type='') {
		$newArray = (Array) @simplexml_load_string($packetOld);
		Foreach($newArray AS $x => $value) {
			If(is_array($value)) {
				Foreach($value AS $p => $values) {
					$type = $this->function->expl0de($packetOld, '<', ' ');
					$packet[trim($p)] = $values;
					$packet['u'] = $this->botInfo['botowner'];
				}
			}
		}
		If(file_exists($this->dir . $this->sep . 'api' . $this->sep . strtolower($type) . '.api.php'))
			include($this->dir . $this->sep . 'api' . $this->sep . strtolower($type) . '.api.php');
	}
}
$botid = (Isset($argv[1]) ? $argv[1] : 1);
$debug = (Isset($argv[2]) ? $argv[2] : 0);
new PROBots($botid, $debug);
?>
