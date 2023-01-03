<?php


namespace App\DtoTransformers\Company;


use App\Dto\Company\CompanyDto;
use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\Pure;

class CompanyTransformer
{
    /**
     * @param Collection|Company $Company
     * @return CompanyDto[]|CompanyDto
     */

    #[Pure] public function transform(Collection|Company $Company): array|CompanyDto
    {
        if ($Company instanceof Model) {
            return $this->getDto($Company);
        }

        $arrayDto = [];
        foreach ($Company as $value) {
            $arrayDto[] = $this->getDto($value);
        }
        if (count($arrayDto) === 1) {
            return $arrayDto[0];
        }

        return $arrayDto;
    }

    #[Pure] private function getDto(Company $company): CompanyDto
    {
        $id = $company->id ?? null;
        $name = $company->name ?? '';
        $description = $company->description ?? '';
        $deleted = $company->deleted ?? false;

        return new CompanyDto($id, $name, $description, $deleted);
    }

}
