

DEF:users_log
BEFORE INSERT{
   SET NEW.total_time_spend = (TIMESTAMPDIFF(SECOND,NEW.start_time,NEW.end_time));
   SET NEW.email = (SELECT email FROM users  WHERE id=NEW.user_id);	
}
AFTER INSERT{
	SET @games_played = (SELECT COUNT(*) FROM users_log WHERE user_id=NEW.user_id);
  	UPDATE users SET games_played = @games_played WHERE id=NEW.user_id;
  	SET @total_time_spent = (SELECT sum(total_time_spend) FROM users_log  WHERE  user_id=NEW.user_id);
  	UPDATE users SET total_time_spent = @total_time_spent WHERE id=NEW.user_id;
}
 
DEF:share_log
BEFORE INSERT{
	   SET NEW.email = (SELECT email FROM users  WHERE id=NEW.user_id);	

}
AFTER INSERT{
	SET @total_shares = (SELECT COUNT(*) FROM share_log  WHERE user_id=NEW.user_id);
  	UPDATE users SET total_shares = @total_shares WHERE id=NEW.user_id;
  	SET @share_count = (SELECT COUNT(*) FROM share_log  WHERE user_id=NEW.user_id AND users_log_id=NEW.users_log_id);
  	UPDATE users_log SET share_count = @share_count WHERE user_id=NEW.user_id AND id=NEW.users_log_id;

}

DEF:image_view_log
AFTER INSERT{
	SET @total_images_view_count = (SELECT COUNT(*) FROM image_view_log  WHERE user_id=NEW.user_id);
  	UPDATE users SET total_images_view_count = @total_images_view_count WHERE id=NEW.user_id;
  	SET @image_view_log = (SELECT COUNT(*) FROM image_view_log  WHERE user_id=NEW.user_id AND users_log_id=NEW.users_log_id);
  	UPDATE users_log SET image_view_log = @image_view_log WHERE user_id=NEW.user_id AND id=NEW.users_log_id;

}

DEF:login_log
BEFORE INSERT{
	   SET NEW.email = (SELECT email FROM users  WHERE id=NEW.user_id AND token=NEW.token);	
}
AFTER INSERT{

	UPDATE users SET retention_count = (SELECT COUNT(*) FROM login_log  WHERE user_id=users.id AND login_type='success');


}

