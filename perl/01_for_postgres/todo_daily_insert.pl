use Time::Local;

############# INIT section #############
$table  = 'todo_daily_time';
$parent = $_TD->{new}{big_task};
$child  = $_TD->{new}{little_task};
$todo   = $_TD->{new}{todo_name};
$period = $_TD->{new}{period};
@wday   = ($_TD->{new}{sun},
           $_TD->{new}{mon},
           $_TD->{new}{tue},
           $_TD->{new}{wed},
           $_TD->{new}{thu},
           $_TD->{new}{fri},
           $_TD->{new}{sat});

=pod
$period = '[2018-12-02,2018-12-12)';
@wday = ('("1970-01-01 09:00:00","1970-01-01 10:00:00")',
         '("1970-01-01 10:00:00","1970-01-01 11:00:00")',
         '("1970-01-01 11:00:00","1970-01-01 12:00:00")',
         '("1970-01-01 12:00:00","1970-01-01 13:00:00")',
         '("1970-01-01 13:00:00","1970-01-01 14:00:00")',
         '("1970-01-01 14:00:00","1970-01-01 15:00:00")',
         '("1970-01-01 15:00:00","1970-01-01 16:00:00")');
=cut

############# MAIN section #############

# period_date
$period_start = &strdate_to_timestamp($period, 'start');
$period_end   = &strdate_to_timestamp($period, 'end');

# match format
$time_fm = '..\:..\:..';

for($i = 0;$i < 7; $i++){
  # split data
  @wday_ary = split(/,/,$wday[$i]);
  $wday_ary[0] =~ /$time_fm/p;
  $start_time = ${^MATCH};
  $wday_ary[1] =~ /$time_fm/p;
  $end_time = ${^MATCH};

  if($i==0){ # sun
    $sun_start = $start_time;
    $sun_end   = $end_time;
  }
  elsif($i==1){ # mon
    $mon_start = $start_time;
    $mon_end   = $end_time;
  }
  elsif($i==2){ # tue
    $tue_start = $start_time;
    $tue_end   = $end_time;
  }
  elsif($i==3){ # wed
    $wed_start = $start_time;
    $wed_end   = $end_time;
  }
  elsif($i==4){ # thu
    $thu_start = $start_time;
    $thu_end   = $end_time;
  }
  elsif($i==5){ # fri
    $fri_start = $start_time;
    $fri_end   = $end_time;
  }
  elsif($i==6){ # sat
    $sat_start = $start_time;
    $sat_end   = $end_time;
  }
}

while( $period_end >= $period_start){

  ($dmy1, $dmy2, $dmy3, $dmy4, $dmy5, $dmy6, $wday, $dmy7) = gmtime($period_start);

  if($wday==0){ # sun
    $start_time = $sun_start;
    $end_time   = $sun_end;
  }
  elsif($wday==1){ # mon
    $start_time = $mon_start;
    $end_time   = $mon_end;
  }
  elsif($wday==2){ # tue
    $start_time = $tue_start;
    $end_time   = $tue_end;
  }
  elsif($wday==3){ # wed
    $start_time = $wed_start;
    $end_time   = $wed_end;
  }
  elsif($wday==4){ # thu
    $start_time = $thu_start;
    $end_time   = $thu_end;
  }
  elsif($wday==5){ # fri
    $start_time = $fri_start;
    $end_time   = $fri_end;
  }
  elsif($wday==6){ # sat
    $start_time = $sat_start;
    $end_time   = $sat_end;
  }

  # check NULL
  if($start_time == NULL || $end_time == NULL){
    # do nothing
  }
  else{
    $query = &gen_insert($table,
                         $period_start, $start_time, $end_time,
                         $parent,
                         $child,
                         $todo);
    
    $rv    = spi_exec_query($query);
  }

  # after
  $period_start += 86400;
}

return;

############# FUNC section #############
sub strdate_to_timestamp {
  # read only Year, Month, Day
  # OD1 = start/end
  my ($STR_period, $STR_OD1) = @_;

# match format
  $date_fm = '....\-..\-..';

  @period_ary = split(/,/,$STR_period);

  if($STR_OD1 eq "start"){
    $period_ary[0] =~ /$date_fm/p;
    ($year, $mon, $mday) = split(/-/,${^MATCH});
  }
  elsif($STR_OD1 eq "end"){
    $period_ary[1] =~ /$date_fm/p;
    ($year, $mon, $mday) = split(/-/,${^MATCH});
  }
  else{
    return -1;
  }

  return timegm( 0, 0, 0, $mday, $mon-1, $year);
}
# -------------------------------------------------------------
sub gen_insert{
  my ($STR_table,
      $TS_date, $STR_time_S, $STR_time_E,
      $STR_parent, $STR_child, $STR_todo) = @_;

  ($dmy1, $dmy2, $dmy3, $mday, $mon, $year) = gmtime($TS_date);

  # timestamp format ---> ("1970-01-01 HH:MM:SS,1970-01-01 HH:MM:SS")
  $ret = sprintf("insert into %s values ('(%d-%d-%d %s,%d-%d-%d %s)'::tsrange,'%s','%s','%s');",
                 $STR_table,
		 $year+1900, $mon+1, $mday, $STR_time_S,
		 $year+1900, $mon+1, $mday, $STR_time_E,
		 $STR_parent, $STR_child, $STR_todo);
  return $ret;
}
