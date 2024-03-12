<?php
/**
 * ��������� ������� ip.nf
 * ��� ������ ��������� ��� �������������
 */
class icmsGeoiplookup {

    /**
     * �������� ���������� ��� ������� �����
     * ������ ���������� ������ � ��������:
     * [
     *      'city'         => �������� ������,
     *      'country'      => �������� ������,
     *      'country_code' => ISO ��� ������,
     *      'latitude'     => ������,
     *      'longitude'    => �������
     *  ]
     * ��� ������ ������
     *
     * @var string
     */
    public static $title = 'ip.nf';

    /**
     * �������� �����, ������������ ������ � �������
     *
     * @param string $ip ip �����
     * @return array
     */
    public static function detect($ip) {

        $result = file_get_contents_from_url('https://ip.nf/' . $ip . '.json', 3, true);

        if (!$result || empty($result['ip'])) {
            return [];
        }

        return [
            'city'         => $result['ip']['city'],
            'country'      => $result['ip']['country'],
            'country_code' => $result['ip']['country_code'],
            'latitude'     => $result['ip']['latitude'],
            'longitude'    => $result['ip']['longitude']
        ];
    }

}