DROP TABLE IF EXISTS `operating_figures_view`;
DROP VIEW IF EXISTS `operating_figures_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost`
SQL SECURITY DEFINER VIEW `operating_figures_view` 
AS select
	`raw_data_table`.`dbsid` AS `dbsid`,
	`raw_data_table`.`cyear` AS `cyear`,
	round(`raw_data_table`.`N12` / (`raw_data_table`.`N2` + `raw_data_table`.`N3`) * 1000,0) AS `B.1.3.1`,
	round(`raw_data_table`.`N16` / (`raw_data_table`.`N2` + `raw_data_table`.`N3`) * 1000,0) AS `B.1.3.2`,
	round((`raw_data_table`.`N215` + `raw_data_table`.`N219` + `raw_data_table`.`N221`) / (`raw_data_table`.`N2` + `raw_data_table`.`N3`) * 1000,0) AS `B.1.4.1`,
	case when (`raw_data_table`.`N176` + `raw_data_table`.`N176_1`) / (`raw_data_table`.`N2` + `raw_data_table`.`N3`) < 10
		then round((`raw_data_table`.`N176` + `raw_data_table`.`N176_1`) / (`raw_data_table`.`N2` + `raw_data_table`.`N3`),1)
		else round((`raw_data_table`.`N176` + `raw_data_table`.`N176_1`) / (`raw_data_table`.`N2` + `raw_data_table`.`N3`),0)
		end AS `B.2.2.1`,
	round((`raw_data_table`.`N178` + `raw_data_table`.`N178_1`) / (`raw_data_table`.`N2` + `raw_data_table`.`N3`) * 1000,0) AS `B.2.2.5`,
	round(`raw_data_table`.`N149` / (`raw_data_table`.`N167` - `raw_data_table`.`N170` + `raw_data_table`.`N174` + `raw_data_table`.`N183` + `raw_data_table`.`N184` + `raw_data_table`.`N191`),2) AS `B.3.1.2`,
	round(`raw_data_table`.`N162` / `raw_data_table`.`N4`,2) AS `B.3.4.1`,
	round(`raw_data_table`.`N223` * 8 / ((`raw_data_table`.`N215` + `raw_data_table`.`N219` + `raw_data_table`.`N221`) * 2080) * 100,1) AS `B.4.2.3`,
	round((`raw_data_table`.`N164` + `raw_data_table`.`N165`) / `raw_data_table`.`N166` * 100,1)  AS `B.4.3.1`
	from `raw_data_table`
order by `raw_data_table`.`cyear`,`raw_data_table`.`dbsid` ;