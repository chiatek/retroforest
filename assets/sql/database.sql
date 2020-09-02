DROP TABLE IF EXISTS queries;
DROP TABLE IF EXISTS menus;
DROP TABLE IF EXISTS settings;
DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS notification_user;
DROP TABLE IF EXISTS notifications;
DROP TABLE IF EXISTS post_category;
DROP TABLE IF EXISTS category;
DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS users;

create table category (
	category_id int(11) unsigned not null auto_increment primary key,
	category_name varchar(100) not null,
	category_slug varchar(100) not null,
	category_parent varchar(100),
	category_description varchar(200),

	UNIQUE (category_name),
	UNIQUE (category_slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

create table settings (
	setting_id int(11) unsigned not null auto_increment primary key,
	setting_title varchar(100),
	setting_tagline varchar(100),
	setting_siteicon varchar(100),
	setting_css varchar(100),
	setting_datetime varchar(100) not null,
	setting_comments tinyint(1),
	setting_comments_email tinyint(1),
	setting_comments_notify tinyint(1),
	setting_dashboard_widgets tinyint(1),
	setting_dashboard_posts tinyint(1),
	setting_dashboard_pages tinyint(1),
	setting_dashboard_comments tinyint(1),
	setting_dashboard_GA tinyint(1),
	setting_GA_trackingid varchar(200),
	setting_GA_code text

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

create table users (
	user_id int(11) unsigned not null auto_increment primary key,
	user_username varchar(20) not null,
	user_password varchar(128) not null,
	user_name varchar(50) not null,
	user_email varchar(100) not null,
	user_role enum('administrator','author','user') not null,
	user_status enum('active','banned','deleted') not null,
	user_activity datetime,
	user_company varchar(100),
	user_birthday date,
	user_country varchar(50),
	user_bio text,
	user_phone varchar(15),
	user_facebook varchar(200),
	user_instagram varchar(200),
	user_linkedin varchar(200),
	user_twitter varchar(200),
	user_youtube varchar(200),
	user_avatar varchar(200),
	user_theme varchar(25) not null,
	user_theme_header varchar(25) not null,
	user_theme_subheader varchar(25) not null,
	user_theme_footer varchar(25) not null,

	UNIQUE (user_username),
	UNIQUE (user_email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

create table posts (
	post_id int(11) unsigned not null auto_increment primary key,
	post_title varchar(100) not null,
	post_slug varchar(100) not null,
	post_author varchar(100) not null,
	post_created datetime not null,
	post_modified datetime not null,
	post_status varchar(25),
	post_description varchar(500),
	post_body text,
	post_image varchar(100),
	post_featured tinyint(1),
	post_meta_caption varchar(100),
	post_meta_description varchar(250),
	post_meta_keywords varchar(100),
	user_id int(11) unsigned not null,

	foreign key (user_id) references users(user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

create table post_category (
	pc_id int(11) unsigned not null auto_increment primary key,
	post_id int(11) unsigned not null,
	category_id int(11) unsigned not null,

	foreign key (post_id) references posts(post_id),
	foreign key (category_id) references category(category_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

create table comments (
	comment_id int(11) unsigned not null auto_increment primary key,
	post_id int(11) unsigned not null,
	comment_date datetime not null,
	comment_name varchar(100) not null,
	comment_email varchar(200),
	comment_website varchar(200),
	comment_text text not null,

	foreign key (post_id) references posts(post_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

create table notifications (
	notification_id int(11) unsigned not null auto_increment primary key,
	notification_title varchar(50),
	notification_text varchar(500),
	notification_image varchar(100),
	notification_startdate date,
	notification_enddate date

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

create table notification_user (
	nu_id int(11) unsigned not null auto_increment primary key,
	notification_id int(11) unsigned not null,
	user_id int(11) unsigned not null,
	nu_dismiss tinyint(1) not null,

	foreign key (notification_id) references notifications(notification_id),
	foreign key (user_id) references users(user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

create table menus (
	menu_id int(11) unsigned not null auto_increment primary key,
	menu_item varchar(100),
	menu_href varchar(100),
	menu_order int(11) unsigned,
	menu_parent_id int(11) unsigned,
	menu_parent_order int(11) unsigned

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

create table queries (
	id int(11) unsigned not null auto_increment primary key,
	name varchar(100) not null,
	table_name varchar(100) not null,
	referenced_table_name varchar(100),
	primary_key varchar(100),
	foreign_key varchar(100),
	select_stmt varchar(200),
	where_stmt varchar(200),
	orderby_stmt varchar(100),
	limit_stmt int(11),
	icon varchar(100),
	add_to_menu varchar(3),
	add_to_dashboard varchar(3),
	user_id int(11) unsigned not null,

	foreign key (user_id) references users(user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO settings (setting_id, setting_datetime, setting_comments, setting_dashboard_widgets, setting_dashboard_posts, setting_dashboard_pages, setting_dashboard_comments, setting_dashboard_GA) VALUES
(1, 'F Y h:i:s A', 1, 1, 1, 1, 1, 0);
