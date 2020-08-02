
############# INIT section #############
$table  = 'todo_daily_time';
$period = 'period';
$parent = 'big_task';
$child  = 'little_task';

$term_data   = $_TD->{new}{period};
$parent_data = $_TD->{new}{big_task};
$child_data  = $_TD->{new}{little_task};

=pod
$term_data   = '[2018-12-02,2018-12-12)';
$parent_data = 'ENGLISH';
$child_data  = 'reading';
=cut

############# MAIN section #############

$term_data =~ /[\[|\(].*[\)|\]]/p;
$term_data = ${^MATCH};

$query = sprintf("delete from %s where not %s <@ '%s'::tsrange and %s='%s' and %s='%s';",
                 $table,
                 $period, $term_data,
                 $parent, $parent_data, $child, $child_data);

$rv = spi_exec_query($query);

return;

############# FUNC section #############

# NONE

# -------------------------------------------------------------

