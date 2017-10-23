<?php
	
	
	
	
	// $selection = array_slice($words, 0, 5);
	
	//return false;
	
	// WPVR Sandbox
	
	
	function wpvr_create_empty_source( $service = 'youtube' ) {
		$empty_source          = json_decode( '{"status":"off","name":"","type":"channel_yt","service":"youtube","era":0,"searchTerm_yt":null,"searchContextType_yt":"everywhere","searchContextChannel_yt":null,"regionCode_yt":null,"playlistId_yt":null,"playlistIds_yt":null,"channelId_yt":null,"channelIds_yt":"","videoIds_yt":null,"searchTerm_vo":null,"groupId_vo":null,"channelId_vo":null,"userId_vo":null,"videoId_vo":null,"searchTerm_dm":null,"regionCode_dm":null,"playlistId_dm":null,"channelId_dm":null,"videoId_dm":null,"channelId_hyt":null,"channelIds_hyt":null,"wantedVideos":"20","wantedVideosBool":"default","orderVideos":"relevance","onlyNewVideos":"on","getVideoStats":"off","getVideoTags":"off","autoPublish":"on","startTime":"","endTime":"","hidePlayerRelated":"off","hidePlayerTitle":"off","hidePlayerAnnotations":"off","downloadThumb":"off","postAppend":"off","appendCustomText":null,"count_test":0,"count_run":0,"count_success":0,"count_fail":0,"count_imported":0,"postCatsSlug":[],"postCats":null,"postAuthor":"1","postDate":"original","postTagsBool":"disabled","postTags":[],"schedule":"hourly","scheduleTime":"04H00","scheduleDay":"monday","scheduleDate":null,"publishedAfter_bool":"default","publishedAfter":"","publishedBefore_bool":"default","publishedBefore":"","havingViews":null,"havingLikes":null,"videoQuality":"any","videoDuration":"any","postContent":"default","sourceAuthor":"1","id":"10000","folders":[]}' );
		$empty_source->service = $service;
		//d( $empty_source );
		
		return $empty_source;
	}
	
	wpvr_create_empty_source();
	
	function wpvr_add_fake_sources( $args = array() ) {
		global $wpvr_vs;
		
		$args = wp_parse_args( $args, array(
			'service' => 'youtube',
			'number'  => 30,
			'videos'  => 5,
			'status'  => 'off',
			'label'  => '',
			'folders'  => array(),
			'terms'   => array(),
		) );
		
		if( count( $args['terms'] ) == 0 ){
			if( true ) {
				$text = "alf a century ago, in the great hippie year of 1967, an acclaimed young American science fiction writer, Roger Zelazny, published his third novel. In many ways, Lord of Light was of its time, shaggy with imported Hindu mythology and cosmic dialogue. Yet there were also glints of something more forward-looking and political. One plot strand concerned a group of revolutionaries who wanted to take their society “to a higher level” by suddenly transforming its attitude to technology. Zelazny called them the Accelerationists.


Lose yourself in a great story: Sign up for the long read email
 Read more
He and the book are largely forgotten now. But as the more enduring sci-fi novelist JG Ballard said in 1971, “what the writers of modern science fiction invent today, you and I will do tomorrow”. Over the past five decades, and especially over the past few years, much of the world has got faster. Working patterns, political cycles, everyday technologies, communication habits and devices, the redevelopment of cities, the acquisition and disposal of possessions – all of these have accelerated. Meanwhile, over the same half century, almost entirely unnoticed by the media or mainstream academia, accelerationism has gradually solidified from a fictional device into an actual intellectual movement: a new way of thinking about the contemporary world and its potential.

Accelerationists argue that technology, particularly computer technology, and capitalism, particularly the most aggressive, global variety, should be massively sped up and intensified – either because this is the best way forward for humanity, or because there is no alternative. Accelerationists favour automation. They favour the further merging of the digital and the human. They often favour the deregulation of business, and drastically scaled-back government. They believe that people should stop deluding themselves that economic and technological progress can be controlled. They often believe that social and political upheaval has a value in itself.

Accelerationism, therefore, goes against conservatism, traditional socialism, social democracy, environmentalism, protectionism, populism, nationalism, localism and all the other ideologies that have sought to moderate or reverse the already hugely disruptive, seemingly runaway pace of change in the modern world. “Accelerationism is a political heresy,” write Robin Mackay and Armen Avanessian in their introduction to #Accelerate: The Accelerationist Reader, a sometimes baffling, sometimes exhilarating book, published in 2014, which remains the only proper guide to the movement in existence.

Advertisement

Like other heresies, accelerationism has had generations of adherents, declared or otherwise: passing its ideas on to each other, refining some and renouncing others, communicating with each other in a private language, coalescing around dominant figures, competing to make the faith’s next breakthrough, splitting into factions, burning out. There are, or have been, accelerationists from the United States, Canada, Britain, Germany, Italy and France. The movement has produced books, essays, journals, manifestos, blogs, social media battles – and cryptic, almost unclassifiable communiques combining dystopian fiction with a dizzying range of political, cultural and economic theory.

Occasionally, accelerationists have held teaching posts at universities. They have held sporadic public gatherings, in order to think out loud, argue and acquire converts. A few recorded fragments of these can be found on YouTube: dim footage of intense young people talking mesmerically about the future, often with electronic music and abstract visuals churning in the background, to sometimes baffled audiences in badly lit lecture rooms.

At any one time, there have probably only been a few dozen accelerationists in the world. The label has only been in regular use since 2010, when it was borrowed from Zelazny’s novel by Benjamin Noys, a strong critic of the movement. Yet for decades longer than more orthodox contemporary thinkers, accelerationists have been focused on many of the central questions of the late 20th and early 21st centuries: the rise of China; the rise of artificial intelligence; what it means to be human in an era of addictive, intrusive electronic devices; the seemingly uncontrollable flows of global markets; the power of capitalism as a network of desires; the increasingly blurred boundary between the imaginary and the factual; the resetting of our minds and bodies by ever-faster music and films; and the complicity, revulsion and excitement so many of us feel about the speed of modern life.

“We all live in an operating system set up by the accelerating triad of war, capitalism and emergent AI,” says Steve Goodman, a British accelerationist who has even smuggled its self-consciously dramatic ideas into dance music, via an acclaimed record label, Hyperdub. “Like it or not,” argues Steven Shaviro, an American observer of accelerationism, in his 2015 book on the movement, No Speed Limit, “we are all accelerationists now.”

 Illustration by Bratislav Milenkovic
 Illustration by Bratislav Milenkovic
Celebrating speed and technology has its risks. A century ago, the writers and artists of the Italian futurist movement fell in love with the machines of the industrial era and their apparent ability to invigorate society. Many futurists followed this fascination into war-mongering and fascism. While some futurist works are still admired, the movement’s reputation has never recovered.

Advertisement

One of the central figures of accelerationism is the British philosopher Nick Land, who taught at Warwick University in the 1990s, and then abruptly left academia. “Philosophers are vivisectors,” he wrote in 1992. “They have the precise and reptilian intelligence shared by all who experiment with living things.” Iain Hamilton Grant, who was one of Land’s students, remembers: “There was always a tendency in all of us to bait the liberal, and Nick was the best at it.”

Since Warwick, Land has published prolifically on the internet, not always under his own name, about the supposed obsolescence of western democracy; he has also written approvingly about “human biodiversity” and “capitalistic human sorting” – the pseudoscientific idea, currently popular on the far right, that different races “naturally” fare differently in the modern world; and about the supposedly inevitable “disintegration of the human species” when artificial intelligence improves sufficiently.

Other accelerationists now distance themselves from Land. Grant, who teaches philosophy at the University of the West of England, says of him: “I try not to read his stuff. Folk [in the accelerationist movement] are embarrassed. They think he’s sounding like a thug. Anyone who’s an accelerationist, who’s reflective, does think: ‘How far is too far?’ But then again, even asking that question is the opposite of accelerationism.” Accelerationism is not about restraint.

Even its critic Benjamin Noys concedes that the movement has an allure. “Accelerate is a sexy word,” he says – not a common thing in philosophy. The determinedly transgressive artists Jake and Dinos Chapman are associates of the movement and longstanding Land collaborators. One of their frenzied, grotesque paintings is on the cover of his collected writings, Fanged Noumena, published in 2011, which contains some of accelerationism’s most darkly fascinating passages. Earlier this year, secondhand copies of the paperback, which is now being reprinted, were on sale on Amazon for £180.

The manic presidency of Donald Trump has been seen as the first mainstream manifestation of an accelerationist politics
In our politically febrile times, the impatient, intemperate, possibly revolutionary ideas of accelerationism feel relevant, or at least intriguing, as never before. Noys says: “Accelerationists always seem to have an answer. If capitalism is going fast, they say it needs to go faster. If capitalism hits a bump in the road, and slows down” – as it has since the 2008 financial crisis – “they say it needs to be kickstarted.” The disruptive US election campaign and manic presidency of Donald Trump, and his ultra-capitalist, anti-government policies, have been seen by an increasing number of observers – some alarmed, some delighted – as the first mainstream manifestation of an accelerationist politics. In recent years, Noys has noticed accelerationist ideas “resonating” and being “circulated” everywhere from pro-technology parts of the British left to wealthy libertarian and far-right circles in America. On alt-right blogs, Land in particular has become a name to conjure with. Commenters have excitedly noted the connections between some of his ideas and the thinking of both the libertarian Silicon Valley billionaire Peter Thiel and Trump’s iconoclastic strategist Steve Bannon.

“In Silicon Valley,” says Fred Turner, a leading historian of America’s digital industries, “accelerationism is part of a whole movement which is saying, we don’t need [conventional] politics any more, we can get rid of ‘left’ and ‘right’, if we just get technology right. Accelerationism also fits with how electronic devices are marketed – the promise that, finally, they will help us leave the material world, all the mess of the physical, far behind.”

To Turner, the appeal of accelerationism is as much ancient as modern: “They are speaking in a millenarian idiom,” promising that a vague, universal change is close at hand. Noys warns that the accelerationists are trying to “claim the future”.

In some ways, Karl Marx was the first accelerationist. His Communist Manifesto of 1848 was as much awestruck as appalled by capitalism, with its “constant revolutionising of production” and “uninterrupted disturbance of all social conditions”. He saw an ever more frantic capitalism as the essential prelude to the moment when the ordinary citizen “is at last compelled to face … his real conditions of life” and start a revolution.

Advertisement

Yet it was in France in the late 1960s that accelerationist ideas were first developed in a sustained way. Shaken by the failure of the leftwing revolt of 1968, and by the seemingly unending postwar economic boom in the west, some French Marxists decided that a new response to capitalism was needed. In 1972, the philosopher Gilles Deleuze and the psychoanalyst Félix Guattari published Anti-Oedipus. It was a restless, sprawling, appealingly ambiguous book, which suggested that, rather than simply oppose capitalism, the left should acknowledge its ability to liberate as well as oppress people, and should seek to strengthen these anarchic tendencies, “to go still further … in the movement of the market … to ‘accelerate the process’”.

Two years later, another disillusioned French Marxist, Jean-François Lyotard, extended the argument even more provocatively. His 1974 book Libidinal Economy declared that even the oppressive aspects of capitalism were “enjoyed” by those whose lives the system reordered and accelerated. And besides, there was no alternative: “The system of capital is, when all’s said and done, natural.”

In France, both books were controversial. Lyotard eventually disowned Libidinal Economy as his “evil book”, and moved on to other subjects. Deleuze and Guattari warned in their next book, A Thousand Plateaus, which was published in 1980 – as relatively benign postwar capitalism was being swept away by the wilder, harsher version of the Thatcher-Reagan era – that too much capitalist acceleration could suck society into “black holes” of fascism and nihilism.

Yet in Britain, Anti-Oedipus and Libidinal Economy acquired a different status. Like much of postwar French philosophy, for decades they were ignored by the academic mainstream, as too foreign in all senses, and were not even translated into English until 1983 and 1993 respectively. But, for a tiny number of British philosophers, the two books were a revelation. Iain Hamilton Grant first came across Libidinal Economy as a master’s student at Warwick in the early 90s. “I couldn’t believe it! For a book by a Marxist to say, ‘There’s no way out of this’, meaning capitalism, and that we are all tiny pieces of engineered desire, that slot into a huge system – that’s a first, as far as I know.” Grant “got hooked”. Instead of writing his dissertation, he spent an obsessive six months producing the first English translation.

Such exploratory philosophy projects were tolerated at Warwick in a way they were not at other British universities. Warwick had been founded in the 1960s as a university that would experiment and engage with the contemporary world. By the 1990s, its slightly isolated out-of-town campus of breeze-block towers and ziggurats looked worn rather than futuristic, but its original ethos lived on in some departments, such as philosophy, where studying avant-garde French writers was the norm. At the centre of this activity was a new young lecturer in the department, Nick Land.

Advertisement

Land was a slight, fragile-looking man with an iron gaze, a soft but compelling voice, and an air of startling intellectual confidence. “Lots of people are clever,” says Grant, “but I’ve never witnessed anyone who could so forensically destroy a thesis.” Robin Mackay, who also became one of Land’s students, remembers: “Nick was always ready to say, ‘Don’t bother reading that.’ But he had read it all!”

By the early 90s Land had distilled his reading, which included Deleuze and Guattari and Lyotard, into a set of ideas and a writing style that, to his students at least, were visionary and thrillingly dangerous. Land wrote in 1992 that capitalism had never been properly unleashed, but instead had always been held back by politics, “the last great sentimental indulgence of mankind”. He dismissed Europe as a sclerotic, increasingly marginal place, “the racial trash-can of Asia”. And he saw civilisation everywhere accelerating towards an apocalypse: “Disorder must increase... Any [human] organisation is ... a mere ... detour in the inexorable death-flow.”

Land gave strange, theatrical lectures: clambering over chairs as he spoke, or sitting hunched over, rocking back and forth. He also spiced his pronouncements with black humour. He would tell lecture audiences, “I work in the field of The Collapse of Western Civilisation Studies.” A quarter of a century on, some former Warwick philosophy students still talk about him with awe. Robin Mackay says, “I think he’s one of the most important philosophers of the last 50 years.”

 Illustration by Bratislav Milenkovic
 Illustration by Bratislav Milenkovic
But for a would-be guide to the future, Land was in some ways quite old-fashioned. Until the late 90s, he used an ancient green-screen Amstrad computer, and his initial Warwick writings contained far more references to 18th- and 19th-century philosophers – Friedrich Nietzsche was a fixation – than to contemporary thinkers or culture. The Warwick version of accelerationism did not crystallise fully until other radicals arrived in the philosophy department in the mid-90s.

Advertisement

Sadie Plant was one of them: a former Birmingham University lecturer in cultural studies, the study of modern popular culture. Mark Fisher, a former student of hers at Birmingham, was another incomer. He was jumpy and intense, while she was warm and approachable. For a time in the early 90s, she and Land were partners.

Like Land, Plant and Fisher had both read the French accelerationists and were increasingly hostile to the hold they felt traditional leftwing and liberal ideas had on British humanities departments, and on the world beyond. Unlike Land, Plant and Fisher were technophiles: she had an early Apple computer, he was an early mobile phone user. “Computers ... pursue accelerating, exponential paths, proliferating, miniaturising, stringing themselves together,” wrote Plant in Zeroes and Ones, a caffeinated 1997 book about the development of computing. Plant and Fisher were also committed fans of the 90s’ increasingly kinetic dance music and action films, which they saw as popular art forms that embodied the possibilities of the new digital era.

With the internet becoming part of everyday life for the first time, and capitalism seemingly triumphant after the collapse of communism in 1989, a belief that the future would be almost entirely shaped by computers and globalisation – the accelerated “movement of the market” that Deleuze and Guattari had called for two decades earlier – spread across British and American academia and politics during the 90s. The Warwick accelerationists were in the vanguard.

Yet there were two different visions of the future. In the US, confident, rainbow-coloured magazines such as Wired promoted what became known as “the Californian ideology”: the optimistic claim that human potential would be unlocked everywhere by digital technology. In Britain, this optimism influenced New Labour. At Warwick, however, the prophecies were darker. “One of our motives,” says Plant, “was precisely to undermine the cheery utopianism of the 90s, much of which seemed very conservative” – an old-fashioned male desire for salvation through gadgets, in her view. “We wanted a more open, convoluted, complicated world, not a shiny new order.”

The Warwick accelerationists were also influenced by their environment. “Britain in the 90s felt cramped, grey, dilapidated,” says Mackay, “We saw capitalism and technology as these intense forces that were trying to take over a decrepit body.” To observe the process, and help hasten it, in 1995 Plant, Fisher, Land, Mackay and two dozen other Warwick students and academics created a radical new institution: the Cybernetic Culture Research Unit (CCRU). It would become one of the most mythologised groups in recent British intellectual history.

The CCRU existed as a fully functional entity for less than five years. For some of that time, it was based in a single office in the tight corridors of the Warwick philosophy department, of which it was an unofficial part. Later, the unit’s headquarters was a rented room in the Georgian town centre of nearby Leamington Spa, above a branch of the Body Shop.

Advertisement

For decades, tantalising references to the CCRU have flitted across political and cultural websites, music and art journals, and the more cerebral parts of the style press. “There are groups of students in their 20s who re-enact our practices,” says Robin Mackay. Since 2007, he has run a respected philosophy publishing house, Urbanomic, with limited editions of old CCRU publications and new collections of CCRU writings prominent among its products.

The CCRU was image-conscious from the start. Its name was deliberately hard-edged, with a hint of the military or the robotic, especially once its members began writing and referring to themselves collectively, without a definite article, as “Ccru”. In 1999, it summarised its history to the sympathetic music journalist Simon Reynolds in the terse, disembodied style that was a trademark: “Ccru ... triggers itself from October 1995, when it uses Sadie Plant as a screen and Warwick University as a temporary habitat ... Ccru feeds on graduate students + malfunctioning academic (Nick Land) + independent researchers ...”

Former CCRU members still use its language, and are fiercely attached to the idea that it became a kind of group mind. Land told me in an email: “Ccru was an entity ... irreducible to the agendas, or biographies, of its component sub-agencies ... Utter submission to The Entity was key.”

These days, Iain Hamilton Grant is an affable, middle-aged professor who wears a waistcoat with a pen in the top pocket. Yet when I asked him to describe the CCRU, he said with sudden intensity: “We made up an arrow! There was almost no disharmony. There was no leisure. We tried not to be apart from each other. No one dared let the side down. When everyone is keeping up with everyone else, the collective element increased is speed.”

The CCRU gang formed reading groups and set up conferences and journals. They squeezed into the narrow CCRU room in the philosophy department and gave each other impromptu seminars. Mackay remembers Steve Goodman, a CCRU member who was particularly interested in military technology and how it was transforming civilian life, “drawing yin and yang on the blackboard, and then talking about helicopters. It wasn’t academic point-scoring – that was exactly what we had all got heartily sick of before the CCRU. Instead it was a build-up of shared references.”

Grant explained: “Something would be introduced into the group. Neuromancer [William Gibson’s 1984 novel about the internet and artificial intelligence] got into the philosophy department, and it went viral. You’d find worn-out paperbacks all over the common room.”

The CCRU was image-conscious from the start. Its name was deliberately hard-edged, with a hint of the military
Land and Plant’s offices in the department also became CCRU hubs. “They were generous with their time,” said Grant, “And he had good drugs – skunk [cannabis]. Although it could be grim going in there, once he started living in his office. There would be a tower of Pot Noodles and underwear drying on the radiator, which he had washed in the staff loos.”

The Warwick campus stayed open late. When the philosophy department shut for the night, the CCRU decamped to the student union bar across the road, where Land would pay for all the drinks, and then to each other’s houses, where the group mind would continue its labours. “It was like Andy Warhol’s Factory,” said Grant. “Work and production all the time.”

Advertisement

In 1996, the CCRU listed its interests as “cinema, complexity, currencies, dance music, e-cash, encryption, feminism, fiction, images, inorganic life, jungle, markets, matrices, microbiotics, multimedia, networks, numbers, perception, replication, sex, simulation, sound, telecommunications, textiles, texts, trade, video, virtuality, war”. Today, many of these topics are mainstream media and political fixations. Two decades ago, says Grant, “We felt we were the only people on the planet who were taking all this stuff seriously.” The CCRU’s aim was to meld their preoccupations into a groundbreaking, infinitely flexible intellectual alloy – like the shape-shifting cyborg in the 1991 film Terminator 2, a favourite reference point – which would somehow sum up both the present and the future.

The main result of the CCRU’s frantic, promiscuous research was a conveyor belt of cryptic articles, crammed with invented terms, sometimes speculative to the point of being fiction. A typical piece from 1996, “Swarmachines”, included a section on jungle, then the most intense strain of electronic dance music: “Jungle functions as a particle accelerator, seismic bass frequencies engineering a cellular drone which immerses the body ... rewinds and reloads conventional time into silicon blips of speed ... It’s not just music. Jungle is the abstract diagram of planetary inhuman becoming.”

 Illustration by Bratislav Milenkovic
 Illustration by Bratislav Milenkovic
The Warwick accelerationists saw themselves as participants, not traditional academic observers. They bought jungle records, went to clubs and organised DJs to play at eclectic public conferences, which they held at the university to publicise accelerationist ideas and attract like minds. Grant remembers these gatherings, staged in 1994, 1995 and 1996 under the name Virtual Futures, as attracting “every kind of nerd under the sun: science fiction fans, natural scientists, political scientists, philosophers from other universities”, but also cultural trend-spotters: “Someone from [the fashion magazine] the Face came to the first one.”

Like CCRU prose, the conferences could be challenging for non-initiates. Virtual Futures 96 was advertised as “an anti-disciplinary event” and “a conference in the post-humanities”. One session involved Nick Land “lying on the ground, croaking into a mic”, recalls Robin Mackay, while Mackay played jungle records in the background. “Some people were really appalled by it. They wanted a standard talk. One person in the audience stood up, and said, ‘Some of us are still Marxists, you know.’ And walked out.”

 Mark Fisher’s K-punk blogs were required reading for a generation
Simon Reynolds
 Read more
Even inside the permissive Warwick philosophy department, the CCRU’s ever more blatant disdain for standard academic practice became an issue. Ray Brassier watched it happen. Now an internationally known philosopher at the American University in Beirut, between 1995 and 2001 he was a part-time mature student at Warwick.

“I was interested in the CCRU, but sceptical,” Brassier says. “I was a bit older than most of them. The CCRU felt they were plunging into something bigger than academia, and they did put their finger on a lot of things that had started to happen in the world. But their work was also frustrating. They would cheerfully acknowledge the thinness of their research: ‘It’s not about knowledge.’ Yet if thinking is just connecting things, of course it’s exciting, like taking amphetamines. But thinking is also about disconnecting things.”

Advertisement

Brassier says that the CCRU became a “very divisive” presence in the philosophy department. “Most of the department really hated and despised Nick – and that hatred extended to his students.” There were increasingly blunt bureaucratic disputes about the CCRU’s research, and how, if at all, it should be externally regulated and assessed. In 1997, Plant resigned from the university. “The charged personal, political and philosophical dynamics of the CCRU were irresistible to many, but I felt stifled and had to get out,” she told me. She became a full-time writer, and for a few years was the British media’s favourite digital academic, an “IT girl for the 21st century”, as the Independent breathlessly billed her in October 1997.

In 1998, Land resigned from Warwick too. He and half a dozen CCRU members withdrew to the room above the Leamington Spa Body Shop. There they drifted from accelerationism into a vortex of more old-fashioned esoteric ideas, drawn from the occult, numerology, the fathomless novels of the American horror writer HP Lovecraft, and the life of the English mystic Aleister Crowley, who had been born in Leamington, in a cavernous terraced house which several CCRU members moved into.

“The CCRU became quasi-cultish, quasi-religious,” says Mackay. “I left before it descended into sheer madness.” Two of the unit’s key texts had always been the Joseph Conrad novel Heart of Darkness and its film adaptation, Apocalypse Now, which made collecting followers and withdrawing from the world and from conventional sanity seem lethally glamorous. In their top-floor room, Land and his students drew occult diagrams on the walls. Grant says a “punishing regime” of too much thinking and drinking drove several members into mental and physical crises. Land himself, after what he later described as “perhaps a year of fanatical abuse” of “the sacred substance amphetamine”, and “prolonged artificial insomnia ... devoted to futile ‘writing’ practices”, suffered a breakdown in the early 2000s, and disappeared from public view.

“The CCRU just vanished,” says Brassier. “And a lot of people – not including me – thought, ‘Good riddance.’”

Half a dozen years later, at the University of Western Ontario in Canada, a mild-mannered political science master’s student, Nick Srnicek, began reading a British blog about pop culture and politics called k-punk. K-punk had been going since 2003, and had acquired a cult following among academics and music critics for its unselfconscious roaming from records and TV shows to recent British history and French philosophy.

Advertisement

K-punk was written by Mark Fisher, formerly of the CCRU. The blog retained some Warwick traits, such as quoting reverently from Deleuze and Guattari, but it gradually shed the CCRU’s aggressive rhetoric and pro-capitalist politics for a more forgiving, more left-leaning take on modernity. Fisher increasingly felt that capitalism was a disappointment to accelerationists, with its cautious, entrenched corporations and endless cycles of essentially the same products. But he was also impatient with the left, which he thought was ignoring new technology when it should have been exploiting it. Srnicek agreed. He and Fisher became friends.

The 2008 financial crisis, and the left’s ineffectual, rather old-fashioned response to it – such as the short-lived street protests of the Occupy movement – further convinced Srnicek that an updated radical politics was needed. In 2013, he and a young British political theorist, Alex Williams, co-wrote a Manifesto for an Accelerationist Politics. “Capitalism has begun to constrain the productive forces of technology,” they wrote. “[Our version of] accelerationism is the basic belief that these capacities can and should be let loose … repurposed towards common ends … towards an alternative modernity.”

What that “alternative modernity” might be was barely, but seductively, sketched out, with fleeting references to reduced working hours, to technology being used to reduce social conflict rather than exacerbate it, and to humanity moving “beyond the limitations of the earth and our own immediate bodily forms”. On politics and philosophy blogs from Britain to the US and Italy, the notion spread that Srnicek and Williams had founded a new political philosophy: “left accelerationism”.

Two years later, in 2015, they expanded the manifesto into a slightly more concrete book, Inventing the Future. It argued for an economy based as far as possible on automation, with the jobs, working hours and wages lost replaced by a universal basic income. The book attracted more attention than a speculative leftwing work had for years, with interest and praise from intellectually curious leftists such as the Labour MP Jon Cruddas and the authors Paul Mason and Mike Davis.

Yet the actual word accelerationism did not appear in the book. “We’ve given up on the term now,” Srnicek told me. “It’s been too popularised. And we don’t just want everything to go faster, anyway. Arguing for a shorter working week is arguing for people’s lives to slow down.”

The 2013 manifesto had mentioned Land’s earlier version of accelerationism in passing, describing it as “acute” and “hypnotising”, but also “myopic” and “confused”. When Srnicek and I met – appropriately, he chose a futuristic public space: a cafe in the angular new extension to Tate Modern – I asked how he regarded Land and the CCRU’s work now. “Land’s stuff is a valid reading of Deleuze and Guattari,” he began politely. “But the inhumanism of it all ... And I’m not sure if returning to the CCRU’s texts is that interesting – all that word-play … Using the word ‘cyber’ seems very 90s.”

I asked Land what he thought of left accelerationism. “The notion that self-propelling technology is separable from capitalism,” he said, “is a deep theoretical error.”

 Illustration by Bratislav Milenkovic
 Illustration by Bratislav Milenkovic
After his breakdown, Land left Britain. He moved to Taiwan “early in the new millennium”, he told me, then to Shanghai “a couple of years later”. He still lives there now. “Life as an outsider was a relief.” China was also thrilling. In a 2004 article for the Shanghai Star, an English-language paper, he described the modern Chinese fusion of Marxism and capitalism as “the greatest political engine of social and economic development the world has ever known”. At Warwick, he and the CCRU had often written excitedly, but with little actual detail, about what they called “neo-China”. Once he lived there, Land told me, he realised that “to a massive degree” China was already an accelerationist society: fixated by the future and changing at speed. Presented with the sweeping projects of the Chinese state, his previous, libertarian contempt for the capabilities of governments fell away.

Advertisement

Back in less revolutionary Britain, Land’s Chinese journalism, a strange amalgam of pro-government propaganda, PR hyperbole, and wild CCRU imagery – “At World Expo 2010 Shanghai … parallel tracks melt together, into the largest discrete event in world history” – went either unnoticed or pointedly ignored during the 2000s and early 2010s. Among the steadily rising number of people with an interest in accelerationism, there was a feeling that Land had taken the philosophy in inappropriate directions.

Other members of the Warwick diaspora made less controversial accommodations with the modern world. Suzanne Livingston, a former CCRU member, joined the international branding agency Wolff Olins, and used PhD work she had done at Warwick on robotics and artificial intelligence to help technology corporations such as Sony and Ericsson. Steve Goodman set up the electronic music label Hyperdub in 2004, and began releasing skeletal, ominous dubstep records, by the lauded south London artist Burial among others, sometimes with accelerationist messages deep within. “It’s like an onion,” he says. “Our audience are welcome to peel off as many layers as they want – some will make their eyes water, so we don’t force feed.”

Between 2002 and 2014, Goodman also lectured in music culture at the University of East London (UEL), which, along with Goldsmiths College in south London, is a frequent employer of former CCRU members. “The Warwick lot are still a group of friends, devoted and loyal to each other,” says a former UEL colleague of Goodman’s. “That’s the good way of putting it. The other way is to say that the CCRU cult thing never stopped.”

Whether British accelerationism is a cult or not, Robin Mackay is at the centre of it. Besides publishing its key texts through Urbanomic, he has kept in touch with most of his former Warwick comrades, even Land, who he has known, and often defended, for 25 years. But Mackay is a less unsettling presence. Forty-three now, he has lived for a decade in a plain village in inland Cornwall. He met me at the nearest station, wearing a severe black shirt and playing complicated techno on his car stereo, with one of his children in the back.

In the living room of his half-renovated cottage, blinds down against the lovely spring day, Mackay talked about accelerationism and its serpentine history for hours, smoking throughout – an old CCRU habit – and blinking slowly between his long sentences, so deliberately and regularly you could see him thinking. Near the end, he said: “Accelerationism is a machine for countering pessimism. In considering untapped possibilities, you can feel less gloomy about the present.” Mackay said he had experienced periods of depression. His close friend, Mark Fisher, who also had depression, took his own life this January.

Towards the end of his life, Fisher was increasingly preoccupied by the idea that Britain was not heading towards some great leap forward, but stasis. For all the freneticism of modern life, in some ways even the most developed countries still live in the opposite of accelerated times: the same parties seemingly perpetually in power; the same sluggish capitalism, still struggling for momentum a decade after the financial crisis; the same yearnings for the good old days, expressed by elderly Brexit voters and nostalgic leftists alike.

Even the thinking of the arch-accelerationist Nick Land, who is 55 now, may be slowing down. Since 2013, he has become a guru for the US-based far-right movement neoreaction, or NRx as it often calls itself. Neoreactionaries believe in the replacement of modern nation-states, democracy and government bureaucracies by authoritarian city states, which on neoreaction blogs sound as much like idealised medieval kingdoms as they do modern enclaves such as Singapore.

In 2013, Land wrote a long online essay about the movement, titled with typical theatricality “The Dark Enlightenment”, which has become widely seen as one of neoreraction’s founding documents. Land argues now that neoreaction, like Trump and Brexit, is something that accelerationists should support, in order to hasten the end of the status quo. Yet the analyst of accelerationism Ray Brassier is unconvinced: “Nick Land has gone from arguing ‘Politics is dead’, 20 years ago, to this completely old-fashioned, standard reactionary stuff.” Neoreaction has a faith in technology and a following in Silicon Valley, but in other ways it seems a backward-looking cause for accelerationists to ally themselves with.

Without a dynamic capitalism to feed off, as Deleuze and Guattari had in the early 70s, and the Warwick philosophers had in the 90s, it may be that accelerationism just races up blind alleys. In his 2014 book about the movement, Malign Velocities, Benjamin Noys accuses it of offering “false” solutions to current technological and economic dilemmas. With accelerationism, he writes, a breakthrough to a better future is “always promised and always just out of reach”.

In 1970, the American writer Alvin Toffler, an exponent of accelerationism’s more playful intellectual cousin, futurology, published Future Shock, a book about the possibilities and dangers of new technology. Toffler predicted the imminent arrival of artificial intelligence, cryonics, cloning and robots working behind airline check-in desks. “The pace of change accelerates,” concluded a documentary version of the book, with a slightly hammy voiceover by Orson Welles. “We are living through one of the greatest revolutions in history – the birth of a new civilisation.”

Shortly afterwards, the 1973 oil crisis struck. World capitalism did not accelerate again for almost a decade. For much of the “new civilisation” Toffler promised, we are still waiting. But Future Shock has sold millions of copies anyway. One day an accelerationist may do the same.";
			}
			$words = str_word_count($text, 1);
			shuffle($words);
			$args['terms'] = $words ;
		}
		
		$count = 0 ;
		
		if( $args['label'] == ''){
			$args['label']= bin2hex( openssl_random_pseudo_bytes( 4 ) );
		}
		for ( $i = 1; $i <= $args['number']; $i ++ ) {
			$source                = wpvr_create_empty_source();
			$source->name          = ' Fake Source ' . $args['label'].' #'.$i;
			$source->type          = 'search_yt';
			$source->searchTerm_yt = $args['terms'][ rand( 0, count( $args['terms'] ) - 1 ) ];
			$source->wantedVideosBool = 'custom';
			$source->wantedVideos = $args['videos'];
			$source->status = $args['status'];
			$source->folders = $args['folders'];
			
			wpvr_import_source( $source );
			
			$count++;
			
		}
		
		d( $count . ' Fake source created.' );
		
	}
	
	// wpvr_add_fake_sources(array(
	// 	'folders' => array(get_term(93,WPVR_SFOLDER_TYPE ) ),
	// 	'status' => 'on',
	// 	'number' => '200',
	// 	'videos' => '5',
	// ));
	