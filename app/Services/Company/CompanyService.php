<?php


namespace App\Services\Company;


use App\Dto\Company\CompanyDto;
use App\Dto\Response\ResponseDto;
use App\Models\Company;
use App\Services\BaseService;
use App\DtoTransformers\Company\CompanyTransformer;

class CompanyService extends BaseService
{

    private CompanyTransformer $companyTransformer;

    public function __construct(CompanyTransformer $companyTransformer)
    {
        $this->companyTransformer = $companyTransformer;
    }

    /**
     * @return CompanyDto|CompanyDto[]
     */
    public function get(): CompanyDto|array
    {
        return $this->companyTransformer->transform(Company::all()->sortBy('id'));
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $region
     * @param string $city
     * @param string $address
     * @return CompanyDto[]|CompanyDto
     */
    public function create(int $id, string $name, string $region, string $city, string $address): array|CompanyDto
    {
        $company = new Company();
        $company->id = $id;
        $company->name = $name;
        $company->region = $region;
        $company->city = $city;
        $company->address = $address;
        $company->save();

        return $this->companyTransformer->transform($company);
    }

    /**
     * @param array $request
     * @return CompanyDto|CompanyDto[]
     */
    public function createFromRequest(array $request): CompanyDto|array
    {
        $model = new Company();
        $params = $this->parseRequest($request, $model->getFillable());
        $company = Company::create($params);

        return $this->companyTransformer->transform($company);
    }

    /**
     * @param int $id
     * @param string|null $name
     * @param string|null $region
     * @param string|null $city
     * @param string|null $address
     * @return CompanyDto[]|CompanyDto
     */
    public function update(int $id, ?string $name = null, ?string $region = null, ?string $city = null, string $address = null): array|CompanyDto
    {
        $company = Company::find($id);

        if ($name) {
            $company->name = $name;
        }
        if ($region) {
            $company->region = $region;
        }
        if ($city) {
            $company->city = $city;
        }
        if ($address) {
            $company->address = $address;
        }

        $company->save();

        return $this->companyTransformer->transform($company);
    }

    /**
     * @param array $request
     * @return CompanyDto|array|ResponseDto
     */
    public function updateFromRequest(array $request): CompanyDto|array|ResponseDto
    {
        $model = new Company();
        $params = $this->parseRequest($request, $model->getFillable());
        $company = Company::find($params['id']);
        unset($params['id']);
        foreach ($params as $key => $value) {
            $company->$key = $value;
        }
        try {
            $company->save();
            $result = $this->companyTransformer->transform($company);

            return new ResponseDto(true, 'successful', $result);
        } catch (\Exception $exception) {
            //create custom exception
            return new ResponseDto(false, 'sql_insert_error', $exception->getMessage(), 500);
        }
    }

    /**
     * @param int $id
     * @return CompanyDto
     */
    public function delete(int $id): CompanyDto
    {
        $company = Company::find($id);
        $company->deleted = true;
        $company->deleted_at = now();
        $company->save();

        return $this->companyTransformer->transform($company);
    }

}
