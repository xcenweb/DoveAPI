<?php
使用工具类 User;

// User::vip_status('过期时间','');
print_r(User::vip_status("2023-01-03 00:00:00","2022-01-01 00:00:00"));