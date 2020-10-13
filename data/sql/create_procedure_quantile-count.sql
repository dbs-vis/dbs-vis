DELIMITER $$
DROP PROCEDURE IF EXISTS `QUANTILE_COUNT`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `QUANTILE_COUNT` (IN `cyear` YEAR, IN `param` CHAR(10), IN `quantile` DECIMAL(3,2), OUT `outputValue` DOUBLE)  NO SQL
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
                                ' FROM dbs_vis_db.operating_figures_view WHERE cyear = ',
                                cyear,
                                ' AND ',
                                param,
                                ' IS NOT NULL ORDER BY ',
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