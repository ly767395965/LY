/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : coc

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-09-21 07:26:15
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `coc_clans`
-- ----------------------------
DROP TABLE IF EXISTS `coc_clans`;
CREATE TABLE `coc_clans` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `clan_tag` varchar(10) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:正常；1偶尔；2死鱼',
  `waring` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0休息；1准备日；2对战日',
  `war_time` int(11) NOT NULL DEFAULT '0',
  `info_tab` tinyint(4) NOT NULL,
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `clan_tag` (`clan_tag`),
  KEY `status` (`status`),
  KEY `waring` (`waring`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of coc_clans
-- ----------------------------

-- ----------------------------
-- Table structure for `coc_clans_info`
-- ----------------------------
DROP TABLE IF EXISTS `coc_clans_info`;
CREATE TABLE `coc_clans_info` (
  `clan_tag` varchar(10) NOT NULL DEFAULT '',
  `clan_name` varchar(30) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类型：0不可加入；1任何人都可加入；2只有被批准才能加入',
  `location_id` int(11) NOT NULL DEFAULT '0',
  `badge_id` tinyint(4) NOT NULL DEFAULT '0',
  `clan_level` tinyint(2) NOT NULL DEFAULT '0',
  `clan_points` int(6) NOT NULL DEFAULT '0',
  `clan_versus_points` int(6) NOT NULL DEFAULT '0',
  `required_trophies` int(5) NOT NULL DEFAULT '0' COMMENT '准入奖杯数',
  `war_frequency` tinyint(1) NOT NULL DEFAULT '0' COMMENT '对战频率:0未设置；1很少；2一周一次；3一周两次；4从不；5始终',
  `war_win_streak` tinyint(4) NOT NULL DEFAULT '0' COMMENT '连胜',
  `war_wins` int(6) NOT NULL DEFAULT '0' COMMENT '胜场',
  `war_ties` tinyint(4) NOT NULL DEFAULT '0' COMMENT '平局',
  `war_losses` int(6) NOT NULL DEFAULT '0' COMMENT '败场',
  `is_war_log_public` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否公开对战日志',
  `members` tinyint(2) NOT NULL DEFAULT '0' COMMENT '成员数',
  `war_log_table` tinyint(4) NOT NULL DEFAULT '0' COMMENT '日志表',
  PRIMARY KEY (`clan_tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of coc_clans_info
-- ----------------------------

-- ----------------------------
-- Table structure for `coc_clans_war_info`
-- ----------------------------
DROP TABLE IF EXISTS `coc_clans_war_info`;
CREATE TABLE `coc_clans_war_info` (
  `log_id` char(32) NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of coc_clans_war_info
-- ----------------------------

-- ----------------------------
-- Table structure for `coc_clans_war_log`
-- ----------------------------
DROP TABLE IF EXISTS `coc_clans_war_log`;
CREATE TABLE `coc_clans_war_log` (
  `log_id` char(32) NOT NULL,
  `clan_tag1` varchar(10) NOT NULL DEFAULT '',
  `result` tinyint(1) NOT NULL DEFAULT '0' COMMENT '胜负：0负；1胜',
  `end_time` int(11) NOT NULL DEFAULT '0',
  `team_size` tinyint(2) NOT NULL DEFAULT '0',
  `clan_name1` varchar(30) NOT NULL DEFAULT '',
  `badge_id1` tinyint(4) NOT NULL DEFAULT '0',
  `clan_level1` tinyint(11) NOT NULL DEFAULT '0',
  `attacks1` tinyint(4) NOT NULL DEFAULT '0' COMMENT '进攻次数',
  `stars1` tinyint(4) NOT NULL DEFAULT '0' COMMENT '星数',
  `percentage1` float(4,2) NOT NULL DEFAULT '0.00' COMMENT '摧毁率',
  `clan_tag2` varchar(10) NOT NULL DEFAULT '',
  `clan_name2` varchar(30) NOT NULL DEFAULT '',
  `badge_id2` tinyint(4) NOT NULL DEFAULT '0',
  `clan_level2` tinyint(11) NOT NULL DEFAULT '0',
  `attacks2` tinyint(4) NOT NULL DEFAULT '0' COMMENT '进攻次数',
  `stars2` tinyint(4) NOT NULL DEFAULT '0' COMMENT '星数',
  `percentage2` float(4,2) NOT NULL DEFAULT '0.00' COMMENT '摧毁率',
  `war_info_tab` tinyint(4) NOT NULL DEFAULT '0' COMMENT '详情表',
  `is_record` tinyint(1) NOT NULL DEFAULT '0' COMMENT '临时字段：是否记录',
  PRIMARY KEY (`log_id`),
  KEY `clan_tag1` (`clan_tag1`),
  KEY `clan_tag2` (`clan_tag2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of coc_clans_war_log
-- ----------------------------

-- ----------------------------
-- Table structure for `coc_locations`
-- ----------------------------
DROP TABLE IF EXISTS `coc_locations`;
CREATE TABLE `coc_locations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `eng_name` varchar(50) NOT NULL DEFAULT '',
  `cn_name` varchar(20) NOT NULL DEFAULT '',
  `is_country` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否国家:0:false 1: true',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:正常; 2:不常用; 3隔离',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32000266 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of coc_locations
-- ----------------------------
INSERT INTO `coc_locations` VALUES ('32000000', 'Europe', '欧洲', '0', '3');
INSERT INTO `coc_locations` VALUES ('32000001', 'North America', '北美洲', '0', '3');
INSERT INTO `coc_locations` VALUES ('32000002', 'South America', '南美洲', '0', '3');
INSERT INTO `coc_locations` VALUES ('32000003', 'Asia', '亚洲', '0', '3');
INSERT INTO `coc_locations` VALUES ('32000004', 'Australia', '澳洲', '0', '3');
INSERT INTO `coc_locations` VALUES ('32000005', 'Africa', '非洲', '0', '3');
INSERT INTO `coc_locations` VALUES ('32000006', 'International', '国际', '0', '3');
INSERT INTO `coc_locations` VALUES ('32000007', 'Afghanistan', '阿富汗', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000008', 'Åland Islands', '奥兰群岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000009', 'Albania', '阿尔巴尼亚', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000010', 'Algeria', '阿尔及利亚', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000011', 'American Samoa', '美属萨摩亚', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000012', 'Andorra', '安道尔共和国', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000013', 'Angola', '安哥拉', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000014', 'Anguilla', '安圭拉岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000015', 'Antarctica', '南极洲', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000016', 'Antigua and Barbuda', '安提瓜和巴布达', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000017', 'Argentina', '阿根廷', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000018', 'Armenia', '亚美尼亚', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000019', 'Aruba', '阿鲁巴岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000020', 'Ascension Island', '阿森松岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000021', 'Australia', '澳大利亚', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000022', 'Austria', '奥地利', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000023', 'Azerbaijan', '阿塞拜疆', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000024', 'Bahamas', '巴哈马', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000025', 'Bahrain', '巴林', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000026', 'Bangladesh', '孟加拉国', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000027', 'Barbados', '巴巴多斯', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000028', 'Belarus', '白俄罗斯', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000029', 'Belgium', '比利时', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000030', 'Belize', '伯利兹', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000031', 'Benin', '贝宁', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000032', 'Bermuda', '百慕大群岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000033', 'Bhutan', '不丹', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000034', 'Bolivia', '玻利维亚', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000035', 'Bosnia and Herzegovina', '波黑', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000036', 'Botswana', '博茨瓦纳', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000037', 'Bouvet Island', '布韦岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000038', 'Brazil', '巴西', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000039', 'British Indian Ocean Territory', '英属印度洋领地', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000040', 'British Virgin Islands', '英属维京群岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000041', 'Brunei', '文莱', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000042', 'Bulgaria', '保加利亚', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000043', 'Burkina Faso', '布基纳法索', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000044', 'Burundi', '布隆迪', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000045', 'Cambodia', '柬埔寨', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000046', 'Cameroon', '喀麦隆', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000047', 'Canada', '加拿大', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000048', 'Canary Islands', '加那利群岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000049', 'Cape Verde', '佛得角', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000050', 'Caribbean Netherlands', '荷兰加勒比区', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000051', 'Cayman Islands', '开曼群岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000052', 'Central African Republic', '中非共和国', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000053', 'Ceuta and Melilla', '休达', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000054', 'Chad', '乍得', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000055', 'Chile', '智利', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000056', 'China', '中国', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000057', 'Christmas Island', '圣诞岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000058', 'Cocos (Keeling) Islands', '科科斯(基林)群岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000059', 'Colombia', '哥伦比亚', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000060', 'Comoros', '科摩罗', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000061', 'Congo (DRC)', '刚果(DRC)', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000062', 'Congo (Republic)', '刚果(Republic)', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000063', 'Cook Islands', '库克群岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000064', 'Costa Rica', '哥斯达黎加', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000065', 'Côte d’Ivoire', '科特迪瓦', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000066', 'Croatia', '克罗地亚', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000067', 'Cuba', '古巴', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000068', 'Curaçao', '库拉索', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000069', 'Cyprus', '塞浦路斯', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000070', 'Czech Republic', '捷克', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000071', 'Denmark', '丹麦', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000072', 'Diego Garcia', '迪戈加西亚环礁', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000073', 'Djibouti', '吉布提', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000074', 'Dominica', '多米尼加', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000075', 'Dominican Republic', '多米尼加共和国', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000076', 'Ecuador', '厄瓜多尔', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000077', 'Egypt', '埃及', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000078', 'El Salvador', '萨尔瓦多', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000079', 'Equatorial Guinea', '赤道几内亚', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000080', 'Eritrea', '厄立特里亚', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000081', 'Estonia', '爱沙尼亚', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000082', 'Ethiopia', '埃塞俄比亚', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000083', 'Falkland Islands', '福克兰群岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000084', 'Faroe Islands', '法罗群岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000085', 'Fiji', '斐济', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000086', 'Finland', '芬兰', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000087', 'France', '法国', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000088', 'French Guiana', '法属圭亚那', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000089', 'French Polynesia', '法属玻利尼西亚', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000090', 'French Southern Territories', '法属南部领地', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000091', 'Gabon', '加蓬', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000092', 'Gambia', '冈比亚', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000093', 'Georgia', '格鲁吉亚', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000094', 'Germany', '德国', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000095', 'Ghana', '加纳', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000096', 'Gibraltar', '直布罗陀', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000097', 'Greece', '希腊', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000098', 'Greenland', '格陵兰', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000099', 'Grenada', '格林纳达', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000100', 'Guadeloupe', '瓜德罗普岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000101', 'Guam', '关岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000102', 'Guatemala', '危地马拉', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000103', 'Guernsey', '格恩西', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000104', 'Guinea', '几内亚', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000105', 'Guinea-Bissau', '几内亚比绍', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000106', 'Guyana', '圭亚那', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000107', 'Haiti', '海地', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000108', 'Heard & McDonald Islands', '麦克唐纳', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000109', 'Honduras', '洪都拉斯', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000110', 'Hong Kong', '香港', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000111', 'Hungary', '匈牙利', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000112', 'Iceland', '冰岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000113', 'India', '印度', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000114', 'Indonesia', '印度尼西亚', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000115', 'Iran', '伊朗', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000116', 'Iraq', '伊拉克', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000117', 'Ireland', '爱尔兰', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000118', 'Isle of Man', '马恩岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000119', 'Israel', '以色列', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000120', 'Italy', '意大利', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000121', 'Jamaica', '牙买加', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000122', 'Japan', '日本', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000123', 'Jersey', '泽西', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000124', 'Jordan', '约旦', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000125', 'Kazakhstan', '哈萨克斯坦', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000126', 'Kenya', '肯尼亚', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000127', 'Kiribati', '基里巴斯', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000128', 'Kosovo', '科索沃', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000129', 'Kuwait', '科威特', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000130', 'Kyrgyzstan', '吉尔吉斯坦', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000131', 'Laos', '老挝', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000132', 'Latvia', '拉脱维亚', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000133', 'Lebanon', '黎巴嫩', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000134', 'Lesotho', '莱索托', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000135', 'Liberia', '利比里亚', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000136', 'Libya', '利比亚', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000137', 'Liechtenstein', '列支敦士登', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000138', 'Lithuania', '立陶宛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000139', 'Luxembourg', '卢森堡', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000140', 'Macau', '澳门', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000141', 'Macedonia (FYROM)', '马其顿', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000142', 'Madagascar', '马达加斯加', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000143', 'Malawi', '马拉维', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000144', 'Malaysia', '马来西亚', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000145', 'Maldives', '马尔代夫', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000146', 'Mali', '马里', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000147', 'Malta', '马耳他', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000148', 'Marshall Islands', '马绍尔群岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000149', 'Martinique', '马提尼克岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000150', 'Mauritania', '毛利塔尼亚', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000151', 'Mauritius', '毛里求斯', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000152', 'Mayotte', '马约特岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000153', 'Mexico', '墨西哥', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000154', 'Micronesia', '密克罗尼西亚', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000155', 'Moldova', '摩尔多瓦', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000156', 'Monaco', '摩纳哥', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000157', 'Mongolia', '蒙古', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000158', 'Montenegro', '黑山共和国', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000159', 'Montserrat', '蒙特塞拉特岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000160', 'Morocco', '摩洛哥', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000161', 'Mozambique', '莫桑比克', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000162', 'Myanmar (Burma)', '缅甸', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000163', 'Namibia', '纳米比亚', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000164', 'Nauru', '瑙鲁', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000165', 'Nepal', '尼泊尔', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000166', 'Netherlands', '荷兰', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000167', 'New Caledonia', '新喀里多尼亚', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000168', 'New Zealand', '新西兰', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000169', 'Nicaragua', '尼加拉瓜', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000170', 'Niger', '尼日尔', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000171', 'Nigeria', '尼日利亚', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000172', 'Niue', '纽埃岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000173', 'Norfolk Island', '诺福克岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000174', 'North Korea', '朝鲜', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000175', 'Northern Mariana Islands', '北马里亚纳群岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000176', 'Norway', '挪威', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000177', 'Oman', '阿曼', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000178', 'Pakistan', '巴基斯坦', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000179', 'Palau', '帕劳群岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000180', 'Palestine', '巴勒斯坦', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000181', 'Panama', '巴拿马', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000182', 'Papua New Guinea', '巴布亚新几内亚', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000183', 'Paraguay', '巴拉圭', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000184', 'Peru', '秘鲁', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000185', 'Philippines', '菲律宾', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000186', 'Pitcairn Islands', '皮特凯恩群岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000187', 'Poland', '波兰', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000188', 'Portugal', '葡萄牙', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000189', 'Puerto Rico', '波多黎各', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000190', 'Qatar', '卡塔尔', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000191', 'Réunion', '留尼汪岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000192', 'Romania', '罗马尼亚', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000193', 'Russia', '俄罗斯', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000194', 'Rwanda', '卢旺达', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000195', 'Saint Barthélemy', '圣巴泰勒米', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000196', 'Saint Helena', '圣赫勒拿岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000197', 'Saint Kitts and Nevis', '西印度群岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000198', 'Saint Lucia', '圣卢西亚岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000199', 'Saint Martin', '圣马丁岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000200', 'Saint Pierre and Miquelon', '密克隆群岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000201', 'Samoa', '萨摩亚群岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000202', 'San Marino', '圣马力诺', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000203', 'São Tomé and Príncipe', '圣多美和普林西比', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000204', 'Saudi Arabia', '沙特阿拉伯', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000205', 'Senegal', '塞内加尔', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000206', 'Serbia', '塞尔维亚', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000207', 'Seychelles', '塞舌尔', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000208', 'Sierra Leone', '塞拉利昂', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000209', 'Singapore', '新加坡', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000210', 'Sint Maarten', '圣马丁', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000211', 'Slovakia', '斯洛伐克', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000212', 'Slovenia', '斯洛文尼亚', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000213', 'Solomon Islands', '所罗门群岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000214', 'Somalia', '索马里', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000215', 'South Africa', '南非', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000216', 'South Korea', '南韩', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000217', 'South Sudan', '南苏丹', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000218', 'Spain', '西班牙', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000219', 'Sri Lanka', '斯里兰卡', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000220', 'St. Vincent & Grenadines', '圣文森岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000221', 'Sudan', '苏丹', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000222', 'Suriname', '苏里南', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000223', 'Svalbard and Jan Mayen', '斯瓦尔巴和扬马延', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000224', 'Swaziland', '斯威士兰', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000225', 'Sweden', '瑞典', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000226', 'Switzerland', '瑞士', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000227', 'Syria', '叙利亚', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000228', 'Taiwan', '台湾省', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000229', 'Tajikistan', '塔吉克斯坦', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000230', 'Tanzania', '坦桑尼亚', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000231', 'Thailand', '泰国', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000232', 'Timor-Leste', '东帝汶', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000233', 'Togo', '多哥', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000234', 'Tokelau', '托克劳群岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000235', 'Tonga', '汤加', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000236', 'Trinidad and Tobago', '特立尼达和多巴哥', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000237', 'Tristan da Cunha', '特里斯坦-达库尼亚群岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000238', 'Tunisia', '突尼斯', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000239', 'Turkey', '土耳其', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000240', 'Turkmenistan', '土库曼斯坦', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000241', 'Turks and Caicos Islands', ' 特克斯和凯科斯群岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000242', 'Tuvalu', '图瓦卢', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000243', 'U.S. Outlying Islands', '美国离岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000244', 'U.S. Virgin Islands', '美属维尔京群岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000245', 'Uganda', '乌干达', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000246', 'Ukraine', '乌克兰', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000247', 'United Arab Emirates', '阿拉伯联合酋长国', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000248', 'United Kingdom', '联合王国', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000249', 'United States', '美国', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000250', 'Uruguay', '乌拉圭', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000251', 'Uzbekistan', '乌兹别克斯坦', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000252', 'Vanuatu', '瓦努阿图', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000253', 'Vatican City', '梵蒂冈城', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000254', 'Venezuela', '委内瑞拉', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000255', 'Vietnam', '越南', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000256', 'Wallis and Futuna', '瓦利斯群岛和富图纳群岛', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000257', 'Western Sahara', '西撒哈拉', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000258', 'Yemen', '也门', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000259', 'Zambia', '赞比亚', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000260', 'Zimbabwe', '津巴布韦', '1', '1');
INSERT INTO `coc_locations` VALUES ('32000261', '', '', '0', '3');
INSERT INTO `coc_locations` VALUES ('32000262', '', '', '0', '3');
INSERT INTO `coc_locations` VALUES ('32000263', '', '', '0', '3');
INSERT INTO `coc_locations` VALUES ('32000264', '', '', '0', '3');
INSERT INTO `coc_locations` VALUES ('32000265', '', '', '0', '3');

-- ----------------------------
-- Table structure for `coc_players`
-- ----------------------------
DROP TABLE IF EXISTS `coc_players`;
CREATE TABLE `coc_players` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `player_tag` varchar(10) NOT NULL DEFAULT '',
  `clan_tag` varchar(10) NOT NULL DEFAULT '',
  `info_tab` tinyint(4) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:正常；1偶尔；2死鱼；9禁止',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '数据更新时间',
  PRIMARY KEY (`id`),
  KEY `player_tag` (`player_tag`),
  KEY `clan_tag` (`clan_tag`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='coc玩家表';

-- ----------------------------
-- Records of coc_players
-- ----------------------------

-- ----------------------------
-- Table structure for `coc_players_info`
-- ----------------------------
DROP TABLE IF EXISTS `coc_players_info`;
CREATE TABLE `coc_players_info` (
  `player_tag` varchar(10) NOT NULL,
  PRIMARY KEY (`player_tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of coc_players_info
-- ----------------------------
