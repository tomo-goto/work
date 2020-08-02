use Time::Local;

$period = '[2018-12-02,2018-12-31)';
$wday   = '("1970-01-01 09:00:00","1970-01-01 10:00:00")';

# match format
$date_fm = '....\-..\-..';
$time_fm = '..\:..\:..';

# split data
@wday_ary = split(/,/,$wday);
$wday_ary[0] =~ /$time_fm/p;
$start_time = ${^MATCH};
$wday_ary[1] =~ /$time_fm/p;
$end_time = ${^MATCH};

# pointer
$period_datePointer = &strdate_to_timestamp($period, 'start');

print &gen_insert('todo_daily_time',
                  $period_datePointer, $start_time, $end_time,
		  'big_task',
		  'little_task',
		  'todo_daily') . "\n";
# -------------------------------------------------------------
# -------------------------------------------------------------
sub strdate_to_timestamp {
  # read only Year, Month, Day
  # OD1 = start/end
  my ($STR_period, $STR_OD1) = @_;

  $date_fm = '....\-..\-..';
  @period_ary = split(/,/,$STR_period);
  print" aaa:$STR_OD1\n";

  if($STR_OD1 eq "start"){
  print" aaa:$STR_OD1\n";
    $period_ary[0] =~ /$date_fm/p;
  #($year, $mon, $mday) = split(/-/,${^MATCH});
  }
  elsif($STR_OD1 eq "end"){
    $period_ary[1] =~ /$date_fm/p;
  }
  else{
    $period_ary[0] =~ /$date_fm/p;
    #return -1;
  }
   # $period_ary[0] =~ /$date_fm/p;

  ($year, $mon, $mday) = split(/-/,${^MATCH});

  return timelocal( 0, 0, 0, $mday, $mon-1, $year);
}

# -------------------------------------------------------------
# -------------------------------------------------------------
sub gen_insert{
  my ($STR_table,
      $TS_date, $STR_time_S, $STR_time_E,
      $STR_parent, $STR_child, $STR_todo) = @_;

  ($dmy1, $dmy2, $dmy3, $mday, $mon, $year) = gmtime($TS_date);

  # timestamp format ---> ("1970-01-01 HH:MM:SS,1970-01-01 HH:MM:SS")
  $ret = sprintf("insert into %s values ('(%d-%d-%d %s,%d-%d-%d %s)'::tsrange,%s,%s,%s)",
                 $STR_table,
		 $year+1900, $mon+1, $mday, $STR_time_S,
		 $year+1900, $mon+1, $mday, $STR_time_E,
		 $STR_parent, $STR_child, $STR_todo);
  return $ret;
}
