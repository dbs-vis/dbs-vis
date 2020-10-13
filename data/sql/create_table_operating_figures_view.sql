DROP VIEW IF EXISTS `operating_figures_view`;
CREATE TABLE `operating_figures_view` (
`dbsid` varchar(5)
,`cyear` year(4)
,`B.1.3.1` double(17,0)
,`B.1.3.2` double(17,0)
,`B.1.4.1` double(17,0)
,`B.2.2.1` double(18,1)
,`B.2.2.5` double(17,0)
,`B.3.1.2` double(19,2)
,`B.3.4.1` double(19,2)
,`B.4.2.3` double(18,1)
,`B.4.3.1` double(18,1)
);