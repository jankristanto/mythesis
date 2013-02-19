-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 19, 2013 at 09:28 AM
-- Server version: 5.5.21
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `thesis`
--

-- --------------------------------------------------------

--
-- Table structure for table `comparisons`
--

CREATE TABLE IF NOT EXISTS `comparisons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `original` text NOT NULL,
  `content` varchar(200) DEFAULT NULL,
  `published` datetime NOT NULL,
  `author` varchar(200) NOT NULL,
  `other` varchar(20) NOT NULL,
  `my` varchar(20) DEFAULT NULL,
  `manual` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=136 ;

--
-- Dumping data for table `comparisons`
--

INSERT INTO `comparisons` (`id`, `original`, `content`, `published`, `author`, `other`, `my`, `manual`) VALUES
(36, 'aduh.. knp ya ngantuk sekali :(', 'aduh kenapa ya ngantuk sekali  ', '2011-10-07 06:38:18', 'angela_sitepu (angela sitepu)', 'negatif', 'negatif', NULL),
(37, '@nurulfarawahida xpe la.. makan maggi sorg2 je la kt umah :(', 'xpe la makan maggi sorg sorg je la kt umah  ', '2011-10-07 06:38:17', 'afiqtaqiuddin (afiq taqiuddin)', 'negatif', 'netral', NULL),
(38, 'udah pake jam dinding aje biar lebih gaul dikit.. hahaha :p rt @dhiradl: jam gue ilang masa :(', 'udah pake jam dinding aja agar lebih gaul dikit hahaha   jam saya hilang masa  ', '2011-10-07 06:38:17', 'etoyinsar (etoy)', 'negatif', 'netral', NULL),
(39, 'nooooo! de pindakaas is op :(', 'nooooo de pindakaas is op  ', '2011-10-07 06:38:17', 'jorinde13 (jorinde duits)', 'negatif', 'netral', NULL),
(40, 'hajuuhh pusing sayaahh toloonng :(', 'hajuuhh pusing sayaahh toloonng  ', '2011-10-07 06:38:16', 'thisisafiez (hafiz maulana)', 'negatif', 'negatif', NULL),
(41, 'nyari tugas, be .. susahnya :(', 'nyari tugas be  susahnya  ', '2011-10-07 06:38:16', 'ellyssa_bs (elissabeth saragih )', 'negatif', 'negatif', NULL),
(42, 'iii pika mah :( rt @rafikanuramalia: @wulandarifirda i dont miss you aaaaah, kan dawe jahat malesin', 'iii pika mah    dont miss kamu aaaaah kan dawe jahat malesin ', '2011-10-07 06:38:16', 'wulandarifirda (firda wulandari)', 'negatif', 'negatif', NULL),
(43, 'pengen nangis gelundungan ag :(', 'ingin menangis gelundungan ag  ', '2011-10-07 06:38:16', 'terryamr (terry amora kinanti)', 'negatif', 'negatif', NULL),
(44, 'sedihhh :( bobo aja deeh', 'sedih  bobo saja deeh ', '2011-10-07 06:38:16', 'belawidiandry (bela r. widiandri)', 'negatif', 'negatif', NULL),
(45, 'banyak game onlen yg udah lama g diurus.. :(', 'banyak game onlen yang udah lama  diurus  ', '2011-10-07 06:38:16', 'awankbluez (wirawan bluez adi)', 'negatif', 'netral', NULL),
(46, '@dungjs c ko ', ' ko  ', '2011-10-07 06:38:15', '_misssimple_ ', 'negatif', 'netral', NULL),
(47, '@khariesarbita romushed ki ketoke :( cct: @heru_marwanto @iqbalhijjry @aang_abdullah @n_isnain @r12ki_ps @syukrirahmad @rindang_persada', 'romushed ini ketoke  cct ', '2011-10-07 06:38:15', 'ardianzzz (ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã¢â‚¬Â¹Ãƒâ€¦Ã¢â‚¬Å“ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€šÃ‚Â¦ ardian trimurti', 'negatif', 'netral', NULL),
(48, '@fahtihahapandi entahla tetibe :( now xdew mood serius :(', 'entahla tetibe  now xdew mood serius  ', '2011-10-07 06:38:15', 'yuz_vee93 (muhd yusri )', 'negatif', 'netral', NULL),
(49, 'gaa semangat kuliah siang :(', 'tidak semangat kuliah siang  ', '2011-10-07 06:38:15', 'lee_llelle (laila muzdalifah)', 'negatif', 'negatif', NULL),
(50, 'hahahaha...trnyata harus posting banyaaaakk???zzz aja deh gwww!!! :(', 'hahahaha   trnyata harus posting banyaaaakk   zzz saja deh gwww  ', '2011-10-07 07:12:02', 'rajnanjar (anjar ariyanti)', 'negatif', 'netral', NULL),
(51, 'pura-pura oon lu ! rt @wowfrontal: gua uda lupa cara pacaran! yang dimulai pertamanya apa? sumpah dah! gua terbiasa sendiri :(', 'pura pura oon kamu   saya uda lupa cara pacaran yang dimulai pertamanya apa sumpah dah saya terbiasa sendiri  ', '2011-10-07 07:12:02', 'mydhelhawanay (ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¾Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€šÃ‚ÂÃƒÆ', 'negatif', 'negatif', NULL),
(52, 'rt @bayutor: bali..pengen ke bali :(', ' bali  pengen ke bali  ', '2011-10-07 07:12:02', 'nickywinston (nicky winston sanger)', 'negatif', 'netral', NULL),
(53, 'q baik* aja juga lan :)  sama kagen :(  ., u ganti numz yaw :) rt @lidyadepp : baik. kmu gmna, dian? kangeen.. (cont) http://t.co/ctsq1tc9', ' baik saja juga lan   sama kagen    kamu ganti numz yaw    baik kamu gmna dian kangeen cont ', '2011-10-07 07:12:01', 'dian_thika (dian tika)', 'negatif', 'positif', NULL),
(54, '@aisyahpahmi haha yeke? hmm untunglah tak datang skolah td amik jacket. :(', 'haha yeke hmm untunglah tidak datang skolah td amik jacket  ', '2011-10-07 07:12:01', 'aimankowalewicz (muhammad aiman)', 'negatif', 'positif', NULL),
(55, '#wishbudget2012 kurangkan tax mcdonald saya :(', 'wishbudget  wishbudget kurangkan tax mcdonald saya  ', '2011-10-07 07:12:00', 'syazwanismail (syazwan gunawan)', 'negatif', 'netral', NULL),
(56, 'ancak pulang pado malangang giko di kosan. huhu amaaaa :(', 'ancak pulang pado malangang giko di kosan huhu amaaaa  ', '2011-10-07 07:12:00', 'uwiwii (dewi puspita fahmi)', 'negatif', 'netral', NULL),
(57, 'etdah baru gw bangga"in lo eh ternyata lo masih sayang sama si mantan loe, ahaha\ncukup tau yah :(', 'etdah baru saya bangga in kamu ah ternyata kamu masih sayang sama si mantan loe ahaha\ncukup tau yah  ', '2011-10-07 07:11:59', 'harshyla (shela harshyla)', 'negatif', 'positif', NULL),
(58, 'duh... :( rt @metro_tv: ayah ditangkap karena skandal perjudian, wayne rooney santai http://t.co/ea82pzgo', 'duh   ayah ditangkap karena skandal perjudian wayne rooney santai ', '2011-10-07 07:11:59', 'lennysuwanto (lenny suwanto)', 'negatif', 'netral', NULL),
(59, 'ngga ada motornya berarti ngga kesini :( hua', 'tidak ada motornya berarti tidak kesini  hua ', '2011-10-07 07:11:58', 'fitriaghassany (fitriaghassany)', 'negatif', 'netral', NULL),
(60, 'folbek donkkrt @ini_mira: sange berat. si bebeb dateng ke kosan. main bentar eh bebeb dah muncrat. gak tuntas :(', 'folbek donkkrt sange berat si bebeb datang ke kosan main bentar ah bebeb dah muncrat tidak tuntas  ', '2011-10-07 07:11:58', 'goodniteboy (happy me :))', 'negatif', 'netral', NULL),
(61, 'kange ibu, farel, fitri. hikz...hikz... :( *meikelabu', 'kange ibu farel fitri hikz   hikz  meikelabu ', '2011-10-07 07:11:58', 'r_khiela (r_khiela)', 'negatif', 'positif', NULL),
(62, 'yaaah.. kq turun lg yah :( rt @ghomila: rt @ciphu_put: lapor: kata mba ratna rating @aishiteru_mnctv di 19 cc @devatambayong @ghomila', 'yaaah kq turun lagi yah    lapor kata mba ratna rating di 19 cc ', '2011-10-07 07:11:57', 'chikamoetz (chika love lcb :*)', 'negatif', 'netral', NULL),
(63, 'gaya banget deh.ntar malem main yuk jemput aku :prt @dillaafa: akunya cape tau :( sampe bp jamber? td aku disitu juga nunggu taxi emang en', 'gaya sangat deh ntar malem main ayo jemput aku prt akunya cape tau  sampai bp jamber td aku disitu juga nunggu taxi memang en ', '2011-10-07 07:11:57', 'tiarawcs (mutiara r)', 'negatif', 'netral', NULL),
(64, 'lasuuuut!rt @egiiegoy: kasiaaann rt @opan_taufan: sepi ya,ga kaya twitter yg lama :(', 'lasuuuut rt kasiaaann  sepi ya ga kaya twitter yang lama  ', '2011-10-07 07:35:21', 'opan_taufan (ahmad taufan)', 'negatif', 'netral', NULL),
(65, 'hmmmm... rt @adhaindriaa gaa bisa uniko buku :(', 'hmmmm  tidak bisa uniko buku  ', '2011-10-07 07:35:21', 'ghaadut (angga taufik nugraha)', 'negatif', 'negatif', NULL),
(66, 'ya harem lah :) kau jd rejal ya :d rt @syabrinaa: maune apa? masa aku sing rejal :( rt @yayaabunumay: aku jd (cont) http://wl.tl/dfzb0', 'ya harem lah  kamu jadi rejal ya   maune apa masa aku sing rejal   aku jadi cont ', '2011-10-07 07:35:21', 'yayaabunumay (ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã‹Å“ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€šÃ‚Â¡ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã¢â‚¬Â¹Ã', 'negatif', 'netral', NULL),
(67, '@ccyyww yah knp yah asa bar ud benerin udh gtu lg syg :( coba restart dulu kompinya syg', 'yah kenapa yah asa bar ud benerin sudah begitu lagi syg  coba restart dulu kompinya syg ', '2011-10-07 07:35:20', 'dimsdimasdimz (dimas b. nirwandhani)', 'negatif', 'netral', NULL),
(68, '*brb mangap* rt @ramondiazhasan: *brb tuangin kemulut km* :* rt @neyneyneshia: maauuuu! #envy :( rt @ramondiazhasan: long island, chivas,', 'brb mangap  brb tuangin kemulut km   maauuuu envy   long island chivas ', '2011-10-07 07:35:20', 'neyneyneshia (neshia nawang suita)', 'negatif', 'netral', NULL),
(69, 'rt @nismaaay ih sungguh ya aku cemburu bgt :(', ' ih sungguh ya aku cemburu banget  ', '2011-10-07 07:35:20', 'zartinac (zartina h c ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¾Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚ÂªÃƒÆ’Ã†â€', 'negatif', 'netral', NULL),
(70, 'di cium pantat panci mau? hahahrt @irddy: pen banget diciuuuum :( haha', 'di cium makian panci mau hahahrt pen sangat diciuuuum  haha ', '2011-10-07 07:35:19', 'yoelchristianto (yoel basiru)', 'negatif', 'netral', NULL),
(71, 'soreee kak@sastiiii \r\nsmoga dibalessss :(', 'soreee smoga dibalessss  ', '2011-10-07 07:35:19', 'decheriy (sb :))', 'negatif', 'netral', NULL),
(72, ':( rt @lu__ci: kgak adaa motor buuuk. rtagdea: @lu__ci gue lg dirumah nih :9', '  kgak adaa motor buuuk rtagdea saya lagi dirumah nih 9 ', '2011-10-07 07:35:18', 'agdea (agatha dea andriani)', 'negatif', 'netral', NULL),
(73, 'iyaa haha cari masalah emg tuh orang :d rt @ginaalyanigha: wah? tanpa sebab de? rt @anandahaniifaah: itu ka nasteng sama orang :( jol marah2', 'iyaa haha cari masalah emg tuh orang   wah tanpa sebab de  itu ka nasteng sama orang  jol marah marah ', '2011-10-07 07:35:18', 'anandahaniifaah (anandaputri(ÃƒÆ’Ã†â€™Ãƒâ€¦Ã‚Â ÃƒÆ’Ã¢â‚¬Â ÃƒÂ¢Ã¢â€šÂ¬Ã¢â€žÂ¢ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã‚Â¹', 'negatif', 'negatif', NULL),
(74, 'aku juga hahaha rt @sir_iqbal: kangen :(', 'aku juga hahaha  kangen  ', '2011-10-07 07:35:18', 'azizhonik (azis riyanto)', 'negatif', 'netral', NULL),
(75, 'gak karuan :( rt @wowfrontal: #ontalmautanya suasana hati kamu sekarang?', 'tidak karuan   ontalmautanya suasana hati kamu sekarang ', '2011-10-07 07:35:18', 'onidiot (lionita putri)', 'negatif', 'netral', NULL),
(76, 'nggak ada duitnya rt @puspamonster: kamu mau ke margo? margo yuk sama aku :( rt (cont) http://t.co/vu1fa2bp', 'tidak ada duitnya  kamu mau ke margo margo ayo sama aku   cont ', '2011-10-07 08:00:50', 'nafarani', 'negatif', 'netral', NULL),
(77, 'he??kok bisaaa??lama amaaat diundurnyah?? " @aldjufrie: sama,ga jd juga :d.. diundur jd juni 2012 la :( rt @lalonglala: huaaaa..iyaaaaa.."', 'he  kok bisaaa  lama amaaat diundurnyah  sama ga jadi juga  diundur jadi juni 2012 la   huaaaa  iyaaaaa ', '2011-10-07 08:00:50', 'lalonglala (fadilla yunidha)', 'negatif', 'netral', NULL),
(78, 'samaaa :( dia pdhl udh mau wamil kan pinn rt @pinkapinas: kok ga rela ya liat leeteuk wgm ', 'samaaa  dia pdhl sudah mau wamil kan pinn  kok tidak rela ya liat leeteuk wgm  ', '2011-10-07 08:00:49', 'kejiaaa (kezia m sapulete)', 'negatif', 'netral', NULL),
(79, 'rt @anastasiadinda: kasihan :(', ' kasihan  ', '2011-10-07 08:00:49', 'fidelisfrd (fidelis rigen deita )', 'negatif', 'netral', NULL),
(80, '@dessyhp moooot masa paketnya cuman bisa buat m.twitter ama m.facebook :'' tai ngedhhhhh :(', 'moooot masa paketnya cuma bisa buat m twitter dengan m facebook  makian ngedhhhhh  ', '2011-10-07 08:00:49', 'nungenung (nur cahayati )', 'negatif', 'negatif', NULL),
(81, 'malasnyaa mw siap2 .. :(', 'malas mw siap siap   ', '2011-10-07 08:00:49', 'putrieprincess (ricalucianaputrie)', 'negatif', 'negatif', NULL),
(82, 'dah asar, belum makan lagi :(', 'dah asar belum makan lagi  ', '2011-10-07 08:21:00', 'harithzuhdi (harith az-zuhdi)', 'negatif', 'netral', NULL),
(83, '@eshamustika @cloudezz klo cover mrsimple japan ky yg korea per member gt trs cover donghae ny bagus. mau beli ah~ tp ktg sok lbh mahal :(', 'kalau cover mrsimple japan ky yang korea per member begitu trs cover donghae ny bagus mau beli ah tapi ktg sok lbh mahal  ', '2011-10-07 08:20:59', 'annebeta203 (anne betari kf ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€¦Ã‚Â¾ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â±Ãƒ', 'negatif', 'positif', NULL),
(84, 'ooh di news room rt @rina_agestya: disini nih...! :p rt @mayyaadnan: pada dimana siiihhhh ? :(', 'ooh di news room  disini nih   pada dimana siiihhhh   ', '2011-10-07 08:20:59', 'mayyaadnan (summaya ilham nur a)', 'negatif', 'netral', NULL),
(85, 'oh iya km gak ada , susah lupa yaa :( rt @ranirachmawati3: ga hehe,wkt halal bihalal katanya ada t... http://kvs.co/jeaj', 'oh iya kamu tidak ada  susah lupa yaa   tidak hehe wkt halal bihalal katanya ada  ', '2011-10-07 08:20:58', 'rizkamaulida1 (rizka maulida)', 'negatif', 'positif', NULL),
(86, 'adek jg bang :( rt @tonkuhasibuan: bawaannya ngantuk mulu', 'adek juga bang   bawaannya ngantuk mulu ', '2011-10-07 08:20:58', 'rantia08 (chyntia harl)', 'negatif', 'netral', NULL),
(87, 'kpa qa da ujang !\n\nhmmp .\nlebe qa nnti malam :(', 'kpa qa ada ujang hmmp lebe qa nnti malam  ', '2011-10-07 08:20:57', 'titha096 (julitha suoth)', 'negatif', 'netral', NULL),
(88, 'mau juga dong : d rt@bebehhciiyell pengen mamam jagungbakar :(', 'mau juga dong  di ingin mamam jagungbakar  ', '2011-10-07 08:20:56', 'bboys_anton (bboy diggity crew)', 'negatif', 'netral', NULL),
(89, 'ngantuk, kepala keliengan :( gara-gara kejedot, pak pak pak', 'ngantuk kepala keliengan  gara gara kejedot pak pak pak ', '2011-10-07 08:20:56', 'adillasuri (adilla surihayati)', 'negatif', 'negatif', NULL),
(90, 'rt @lemaalemoo siangg semuanya .. mentions nya dong , sepi banget nii :(', ' siangg semuanya  mentions nya dong  sepi sangat nii  ', '2011-10-07 08:20:55', 'ari_pato (ardian wirnata)', 'negatif', 'netral', NULL),
(91, 'rt @ayseozyilmazel: aaah ah! :(', ' aaah ah  ', '2011-10-07 08:20:54', 'hilalfidan3 (hilal fidan)', 'negatif', 'netral', NULL),
(92, 'namanya juga kerja dek :( rt @lovikaergina: lagi nunggu pulang bg, lama betul  rt @rendriwidianto: ... http://t.co/nk3sooin', 'namanya juga kerja dek   lagi nunggu pulang bg lama benar    ', '2011-10-07 08:20:54', 'rendriwidianto (rendri hafishsam wd)', 'negatif', 'positif', NULL),
(93, 'di nanaman ako nakinig ng lesson sa math :( lumilipad kasi ung utak ko kanina iniisip si *toot*', 'di nanaman ako nakinig ng lesson bisa math  lumilipad kasi ung utak ko kanina iniisip si toot ', '2011-10-07 08:41:02', 'imamayzing (may valmores)', 'negatif', 'positif', NULL),
(94, 'ga kebayang kalo tinggal di bantar gebang :(', 'tidak kebayang kalau tinggal di bantar gebang  ', '2011-10-07 08:41:02', 'sellyanggi (selly anggita)', 'negatif', 'netral', NULL),
(95, 'sesuju, seokyu n haesica rt @sherinadiita: kenapa gak seohyun-kyuhyun aja sih?? :( donghae ft. jessica dehh !', 'sesuju seokyu dan haesica  kenapa tidak seohyun kyuhyun saja sih  donghae ft jessica dehh  ', '2011-10-07 08:41:02', 'fitriloissun (fitri lois sun)', 'negatif', 'netral', NULL),
(96, 'sama :( rt @ikaelvira: @ulannlann @puutputriii @jennodd aduh2 libut lah -__- hahaha kangen behapakan dgn kalian :(', 'sama   aduh aduh libut lah  hahaha kangen behapakan dengan kalian  ', '2011-10-07 08:41:01', 'jennodd (jennifer claudia)', 'negatif', 'negatif', NULL),
(97, 'bagus. kyk gitu jak trus. makasih bnyk.. rt @eviegusyantie: shit yag semuanya :( rt ambro_sius: sama lah. rt eviegusyantie: udah ach capek a', 'bagus kyk begitu jak trus makasih bnyk  makian yag semuanya   ambro sius sama lah  eviegusyantie udah ach capek  ', '2011-10-07 08:41:01', 'ambro_sius (amrosius nau)', 'negatif', 'netral', NULL),
(98, 'nah kda meakui pulang @aditcahya  liati  rt @kikijoan: ada ae sih hhart @elmafeby: mna inya ? rt @kikijoan: mana ada :( hhurt', 'nah kda meakui pulang  liati   ada ae sih hhart mna inya   mana ada  hhurt ', '2011-10-07 08:41:01', 'elmafeby (elma feby ikawati)', 'negatif', 'netral', NULL),
(99, 'upz =) hehe maaf deh kn anak.a demian mah msh kecil  rt @ruthanggraeni: aku udh gede, masa kecill truzz.. :( rt @ayumeidhita: oh y', 'upz  hehe maaf deh kan anak a demian mah msh kecil   aku sudah gede masa kecill truzz   oh  ', '2011-10-07 08:41:01', 'ayumeidhita (ayu meidhita putri)', 'negatif', 'netral', NULL),
(100, 'hari ini mmh ultah tp bingung mau ngsh apa :(', 'hari ini mmh ultah tapi bingung mau ngsh apa  ', '2011-10-07 08:41:00', 'thasalamah (thanadia salamah)', 'negatif', 'negatif', NULL),
(101, 'rt @afraarmani: aku takut untuk kehilangan mu :( takut dirimu pergi kembali padanya', ' aku takut untuk kehilangan mu  takut dirimu pergi kembali padanya ', '2011-10-07 08:41:00', 'nurulauliahg (n.u.r.u.l)', 'negatif', 'negatif', NULL),
(102, 'rt @thehottestb2uty: yah wooyoung uda lama ga tweet ya? jgan2 lupa password lgi :(', ' yah wooyoung uda lama tidak tweet ya jgan jgan lupa password lgi  ', '2011-10-07 08:41:00', '971125_ (ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â«ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€¦Ã‚Â¡ÃƒÆ’Ã¢â‚¬Â¹Ãƒâ€¦Ã¢â‚¬Å“ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â«', 'negatif', 'positif', NULL),
(103, 'dianya sakitttttttttttttt rt @vannyhaerunisa tapi ko sedih ka ? rt @windihihihi @vannyhaerunisa sekarang udah ada :(', 'dianya sakitttttttttttttt  tapi ko sedih ka   sekarang udah ada  ', '2011-10-07 08:40:59', 'windihihihi (windi alifiya)', 'negatif', 'negatif', NULL),
(104, 'pusing :(', 'pusing  ', '2011-10-07 08:40:58', 'fahmaayudiany (fahma ayudiany)', 'negatif', 'negatif', NULL),
(105, 'oiih lah mbem :( @fitarry: kan km tadi emm lo rt @muhammadfajar_: bem aja kah ? :d rt @fitarry: bem hha rt @muhammadfajar_: emmm rt', 'oiih lah mbem  kan kamu tadi emm kamu  bem saja kah    bem hha  emmm  ', '2011-10-07 08:40:58', 'muhammadfajar_ (muhammad fajar)', 'negatif', 'netral', NULL),
(106, 'maths :(', 'maths  ', '2011-10-07 09:00:44', 'shazzatweeted (shannon weiland)', 'negatif', 'netral', NULL),
(107, 'anggota smsh semua sombong yaa, kok nggak pernah bls mention :( rt @ilhamfauzie', 'anggota smsh semua sombong yaa kok tidak pernah balas mention   ', '2011-10-07 09:00:44', 'asmita_intan (asmita intan)', 'negatif', 'negatif', NULL),
(108, '@ilhamfauzie bales mention aku skalii ajadong :(', 'balas mention aku skalii ajadong  ', '2011-10-07 09:00:44', 'ika_bismaniac (ika ari murti)', 'negatif', 'netral', NULL),
(109, 'rt @thebusukers: apa coba arti gue buat lo? ada nggk? nggk ada ya? yahh :(', ' apa coba arti saya buat lo ada nggk nggk ada ya yahh  ', '2011-10-07 09:00:43', 'syifaamelia09 (syifayong)', 'negatif', 'netral', NULL),
(110, 'gua tkut :(', 'saya takut  ', '2011-10-07 09:00:43', 'adelineangelica (adeline angelica ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¾Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã¢â‚¬Â¹ÃƒÂ¢Ã', 'negatif', 'negatif', NULL),
(111, '@chota_bhim @jainpreeti91 toh kya mai b tre tarah celebs ki maara karun humesha tweets se? #thatswierd :(', 'toh kya mai  tre tarah celebs ini maara karun humesha tweets se thatswierd  ', '2011-10-07 09:00:43', 'beingtejan (tÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€¦Ã‚Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¬j@n $hrivast@va)', 'negatif', 'netral', NULL),
(112, 'niatnya sih bsok pngen pulang ke tasik,, v gx di kasih izin ma bos!! :( pdhal bsok ada acara sleksi dkr ! :( rt @marriachilomz liburan ja :p', 'niatnya sih besok pngen pulang ke tasik  gx di kasih izin dengan bos  pdhal besok ada acara sleksi dkr    liburan ja  ', '2011-10-07 09:00:42', 'mainahrangga (mutz mainah)', 'negatif', 'netral', NULL),
(113, 'rudet ung. pusing pala ane :(', 'rudet ung pusing pala ane  ', '2011-10-07 09:00:42', 'nessyadanthy (nessya adanthy ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã¢â‚¬Â¹Ãƒâ€¦Ã¢â‚¬Å“ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â®)', 'negatif', 'negatif', NULL),
(114, '@edmiraldo @dydyah hidup kalian enak banget yah :(', 'hidup kalian enak sangat yah  ', '2011-10-07 09:00:42', 'afwanovich (afwan albasit)', 'negatif', 'positif', NULL),
(115, '@andsur folback dong cantiik :) yg lain di folback masa aku engga :(', 'folback dong cantiik  yang lain di folback masa aku tidak  ', '2011-10-07 09:00:42', 'syifa_prasetya (syifa m. prasetya)', 'negatif', 'netral', NULL),
(116, 'salah potong :( #apess', 'salah potong  apess ', '2011-10-07 09:00:41', 'octa_zillvana (octa sianturi)', 'negatif', 'negatif', NULL),
(117, 'sepiiiiiii sepiiiiii aja nih :(', 'sepiiiiiii sepiiiiii saja nih  ', '2011-10-07 09:00:40', 'nikitaurinee (nikita aurina sompie)', 'negatif', 'netral', NULL),
(118, '@ilhamfauzie gitu ya kaaa,,, udah pake capslok semua ini,, keliatan? bales dong :(', 'begitu ya kaaa udah pake capslok semua ini keliatan balas dong  ', '2011-10-07 09:00:40', 'ddyasb_twibi (nadya annistya aisy)', 'negatif', 'netral', NULL),
(119, 'cuihhhh pede banget lu --p rt @ichaaprmta: makasih :) rt regitta_nia: envy sama dia :( keren bangett ><', 'cuihhhh pede sangat kamu   makasih   regitta nia envy sama dia  keren bangett  ', '2011-10-07 09:00:40', 'regitta_nia (regita yustania/ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚ÂÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â´ÃƒÆ’Ã†â€™Ãƒâ€', 'negatif', 'positif', NULL),
(120, 'sumpa yo , aku nyesek tiap hari liat kamu ama "dia", temenku ndri ! :(', 'sumpa yo  aku nyesek tiap hari liat kamu dengan dia temenku ndri   ', '2011-10-07 09:00:39', 'triarawr (tria karisma amalia)', 'negatif', 'netral', NULL),
(121, 'kalo emg aku ad slh sm situ,aku minta maaf :(', 'kalau emg aku ada slh sm situ aku minta maaf  ', '2011-10-07 09:21:00', 'ichaaacucutt (icha (^o^)/ )', 'negatif', 'netral', NULL),
(122, 'rt @obefiend: rt @fahmi_fadzil: 54 tahun merdeka, 48 tahun sebagai malaysia - kenapa kita masih bercakap mengenai "bekalan air bersih"? :(', '  54 tahun merdeka 48 tahun sebagai malaysia  kenapa kita masih bercakap mengenai bekalan air bersih  ', '2011-10-07 09:21:00', 'bell_ed (nabilah)', 'negatif', 'positif', NULL),
(123, 'kok lu gangasih tauin ngetweet ke gua dar?? :( rt @dardidam siapa aja?gua udah kmren nggi rt @anggiemdm hari ini pada ke223, tapi gacalling2', 'kok kamu gangasih tauin ngetweet ke saya dar   siapa aja gua udah kmren nggi  hari ini pada ke ke tapi gacalling gacalling ', '2011-10-07 09:21:00', 'anggiemdm (anggie mia)', 'negatif', 'netral', NULL),
(124, '@nabilharly masa gue rata rata uh dpt 7 ._. sumph menurun bgt nilai gua :(', 'masa saya rata rata uh dapat 7  sumph menurun banget nilai saya  ', '2011-10-07 09:21:00', 'robbyn_nadda (robbyn ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã¢â‚¬Â¦ÃƒÂ¢Ã¢â€šÂ¬Ã…â€œÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€šÃ‚Â)', 'negatif', 'negatif', NULL),
(125, 'ini lagi urut :(rt @beaselsa: hah? :( terus udah berobat atau urut atau gimana gituh? rt @titoaryonugroho luka dalee', 'ini lagi urut rt hah  terus udah berobat atau urut atau bagaimana gituh  luka dalee ', '2011-10-07 09:21:00', 'titoaryonugroho (tito aryo n)', 'negatif', 'netral', NULL),
(126, '*terharu* rt @tasyaaja: ga jadi bal , dia keluarnya sore :( rt @muhamadbachtiar: *ehem* rt @tasyaaja: nungguin 122', 'terharu  tidak jadi bal  dia keluarnya sore   ehem  menunggu 1 1 ', '2011-10-07 09:21:00', 'muhamadbachtiar (m.i.bachtiar)', 'negatif', 'netral', NULL),
(127, '@naotakun awh :( !!!!!', 'awh   ', '2011-10-07 09:20:59', 'tinycapn (lil childs minamitsu)', 'negatif', 'netral', NULL),
(128, '@riostevadit rio uda off ya? padahal mentionku blum kamu bles lho :(', 'rio uda off ya padahal mentionku belum kamu bles lho  ', '2011-10-07 09:20:59', 'zeniiv (zeni virdiani)', 'negatif', 'netral', NULL),
(129, 'males ngomong . tenggorokan sakit :(', 'males ngomong  tenggorokan sakit  ', '2011-10-07 09:20:59', 'tiaathiaa (ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¾Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¡sydeasÃƒÆ’Ã†â€™Ãƒâ€', 'negatif', 'negatif', NULL),
(130, 'ohya ?iya ntr gampang :*rt @afnirani: oke ', 'ohya iya ntr gampang rt baik  ', '2011-10-07 09:20:59', 'rizkymedhina (baiq rizky medhina)', 'negatif', 'positif', NULL),
(131, 'rt @fidiabimbbamb: yaa kak :( kasian beudss :p rt @yosuadpkcafys:ksian y,, :) rt @fidiabimbbamb: gag da yg ngertiin syaa :(', ' yaa kakak  kasian beudss      gag ada yang ngertiin syaa  ', '2011-10-07 09:20:59', 'yosuadpkcafys (yosua dwi putra k)', 'negatif', 'netral', NULL),
(132, '@citrachang gmna mau d cari.. w aja dh gk bsa buka fb :( aaaaaaaaaa ', 'bagaimana mau di cari  saja dh tidak bisa buka fb  aaaaaaaaaa  ', '2011-10-07 09:20:58', 'chellelie08', 'negatif', 'negatif', NULL),
(133, 'yah putu jgn ngambek dong :( ayo ikut rt @dewiamertha: ok fine gue ga diajak!! rt @landypraditya: @paramithadskd @va... http://t.co/pl2klubg', 'yah putu jangan ngambek dong  ayo ikut  baik fine saya tidak diajak  ', '2011-10-07 09:20:58', 'vanyvarinia (varinia yuniar)', 'negatif', 'negatif', NULL),
(134, '@sytatasyta lhoo syta maaf, ngga keliatan mentionmu, tumpuk-tumpuk sih :-(', 'lhoo syta maaf tidak keliatan mentionmu tumpuk tumpuk sih  ', '2011-10-07 09:41:30', 'febrinafitweet (febrina fithrianti)', 'negatif', 'netral', NULL),
(135, 'apa sih nilai kimia ini :(', 'apa sih nilai kimia ini  ', '2011-10-07 09:41:29', 'ndhyshawty (shindy egia)', 'negatif', 'netral', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
