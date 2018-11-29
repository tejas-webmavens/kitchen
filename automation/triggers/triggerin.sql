DEF:settings
BEFORE INSERT{     
   INSERT INTO settings_log(setting_id,setting_label,setting_slug,setting_value,setting_help_text,sort_order,encrypted,audit_created_by,audit_updated_by,audit_created_date,audit_updated_date,audit_ip)
   VALUES(NEW.id,NEW.setting_label,NEW.setting_slug,NEW.setting_value,NEW.setting_help_text,NEW.sort_order,NEW.encrypted,NEW.audit_created_by,NEW.audit_updated_by,NEW.audit_created_date,NEW.audit_updated_date,NEW.audit_ip);        
}
DEF:settings
BEFORE UPDATE{     
   INSERT INTO settings_log(setting_id,setting_label,setting_slug,setting_value,setting_help_text,sort_order,encrypted,audit_created_by,audit_updated_by,audit_created_date,audit_updated_date,audit_ip)
   VALUES(NEW.id,NEW.setting_label,NEW.setting_slug,NEW.setting_value,NEW.setting_help_text,NEW.sort_order,NEW.encrypted,NEW.audit_created_by,NEW.audit_updated_by,NEW.audit_created_date,NEW.audit_updated_date,NEW.audit_ip);        
}
DEF:settings
BEFORE DELETE{     
   INSERT INTO settings_log(setting_id,setting_label,setting_slug,setting_value,setting_help_text,sort_order,encrypted,audit_created_by,audit_updated_by,audit_created_date,audit_updated_date,audit_ip)
   VALUES(OLD.id,OLD.setting_label,OLD.setting_slug,OLD.setting_value,OLD.setting_help_text,OLD.sort_order,OLD.encrypted,OLD.audit_created_by,OLD.audit_updated_by,OLD.audit_created_date,OLD.audit_updated_date,OLD.audit_ip);        
}