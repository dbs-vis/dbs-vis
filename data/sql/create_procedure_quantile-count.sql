DELIMITER $$
DROP PROCEDURE IF EXISTS `QUANTILE_COUNT`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `QUANTILE_COUNT`(IN cyear YEAR, IN param CHAR(10), IN quantile DECIMAL(3,2), OUT outputValue DOUBLE)
BEGIN
        SET @rowindex := -1;
        SET @sql = CONCAT(      'SELECT (MIN(b.',
                                param,
                                ')+(MAX(b.',
                                param,
                                ')-MIN(b.',
                                param,
                                '))*',
                                quantile,
                                ') INTO @outputValue FROM (SELECT @rowindex:=@rowindex + 1 AS rowindex, ',
                                param,
                                ' FROM ( SELECT
                                            dbsid,
                                            cyear,
                                            ROUND(N12/(N2+N3)*1000) AS `B.1.3.1`,
                                            ROUND(N16/(N2+N3)*1000) AS `B.1.3.2`,
                                            ROUND((N215+N219+N221)/(N2+N3)*1000) AS `B.1.4.1`,
                                            CASE WHEN (N176+N176_1)/(N2+N3) < 10 THEN ROUND((N176+N176_1)/(N2+N3), 1) ELSE ROUND((N176+N176_1)/(N2+N3)) END AS `B.2.2.1`,
                                            ROUND((N178+N178_1)/(N2+N3)*1000) AS `B.2.2.5`,
                                            ROUND(N149/(N167-N170+N174+N183+N184+N191), 2) AS `B.3.1.2`,
                                            ROUND(N162/N4, 2) AS `B.3.4.1`,
                                            ROUND(N223*8/((N215+N219+N221)*2080)*100, 1) AS `B.4.2.3`,
                                            ROUND((N164+N165)/N166*100, 1) AS `B.4.3.1`
                                        FROM dbs_vis_db.raw_data_table
                                        ORDER BY cyear, dbsid) AS t
                                    WHERE t.cyear = ',
                                cyear,
                                ' AND t.',
                                param,
                                ' IS NOT NULL ORDER BY t.',
                                param,
                                ') AS b WHERE b.rowindex IN (FLOOR(@rowindex * ',
                                quantile,
                                '), CEIL(@rowindex * ',
                                quantile,
                                '))'
        );
        PREPARE stmt FROM @sql;
        EXECUTE stmt;
        DEALLOCATE PREPARE stmt;

        SET outputValue = @outputValue;

END$$
DELIMITER ;