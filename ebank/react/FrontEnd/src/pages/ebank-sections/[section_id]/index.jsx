import { getData } from "@utils/getData";
import PageLayoutServices from "@components/page-layout-services";
import myStaticServices from "../../../data/my-static-services.json";

export async function getServerSideProps(context) {
    const data = await getData(`ebank-sections/${context.query.section_id}`);
    return {
        props: {
            ...data,
            sectionId: context.query.section_id,
        },
    };
}

const Home = ({ myItems, sectionId, className }) => {
    const item = myStaticServices.find((item) => item.slug === "ebank");
    const hasSections = item ? item.hasSections : null;
    return (
        <PageLayoutServices
            pageTitle="البنوك الإلكترونية"
            items={myItems?.ebanks}
            resourceType="ebank"
            sectionId={sectionId}
            hasSection={hasSections}
        />
    );
};

export default Home;
