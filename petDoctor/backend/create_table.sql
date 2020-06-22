CREATE TABLE `cd_petwiki` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `category_id` int(11) NOT NULL COMMENT '分类',
  `order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标题',
  `short_title` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '短标题',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '内容',
  `type` enum('cat','dog') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '类型',
  `createtime` int(11) NOT NULL,
  `updatetime` int(11) NOT NULL,
  `deletetime` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='宠物百科';

CREATE TABLE `cd_txvideo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `vid` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '视频ID',
  `headimage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '视频图片',
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '视频标题',
  `createtime` int(11) NOT NULL,
  `updatetime` int(11) NOT NULL,
  `deletetime` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='腾讯视频';
