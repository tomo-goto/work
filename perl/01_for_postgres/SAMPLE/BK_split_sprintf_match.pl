
$table = 'todo_daily_time';
$parent = 'big_task';
$child  = 'little_task';
$todo   = 'todo_daily';

$period = 'VAL';
########## INIT DB_data ##########

$period_test = '[2018-12-01, 2018/12/31)';

@period_ary  = split(/,/,$period_test);
# print $period_ary[0]  . "\n";
# print $period_ary[1]  . "\n";

$mon_test    = '("1970-01-01 09:00:00","1970-01-01 10:00:00")';
$wday        = $mon_test;

@wday_ary = split(/,/,$wday);
# print $wday_ary[0]  . "\n";
# print $wday_ary[1]  . "\n";

$period_ary[0] =~ /....\-..\-../p;

print ${^MATCH} . "\n";
# ${^PREMATCH} ... ${^POSTMATCH}

# print $period . "\n";
# print $mon . "\n";

$sql = sprintf("insert into %s values (%s,%s,%s,%s)",$table,
                                                     $period,
                                                     $parent,
                                                     $child,
                                                     $todo );

print $sql . "\n";

